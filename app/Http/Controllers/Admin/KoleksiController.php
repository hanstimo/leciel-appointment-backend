<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Koleksi;
use App\Models\KoleksiUnavailableDate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class KoleksiController extends Controller
{
    public function index(Request $request)
    {
        $koleksis = Koleksi::orderBy('kategori')->orderBy('nama_koleksi')->get();

        return view('koleksi.index', compact('koleksis'));
    }

    public function toggleTersedia(Koleksi $koleksi)
    {
        $koleksi->update(['tersedia' => ! $koleksi->tersedia]);

        return back()->with('success', "Availability of \"{$koleksi->nama_koleksi}\" updated.");
    }

    /** Halaman kelola koleksi: hanya menampilkan blokir yang masih berlaku. */
    public function edit(Koleksi $koleksi)
    {
        $koleksi->load('unavailableDates');

        [$aktif, $riwayat] = $this->pisahkan($koleksi->unavailableDates);

        return view('koleksi.edit', [
            'koleksi'       => $koleksi,
            'aktif'         => $aktif,
            'jumlahRiwayat' => $riwayat->count(),
        ]);
    }

    /** Halaman tersendiri untuk blokir yang tanggalnya sudah terlewat. */
    public function history(Koleksi $koleksi)
    {
        $koleksi->load('unavailableDates');

        [, $riwayat] = $this->pisahkan($koleksi->unavailableDates);

        return view('koleksi.history', compact('koleksi', 'riwayat'));
    }

    /**
     * Memisahkan rentang yang masih berlaku dari yang sudah terlewat.
     * Rentang yang sedang berlangsung tetap dihitung sebagai blokir aktif.
     *
     * @return array{0: Collection, 1: Collection}
     */
    private function pisahkan(Collection $tanggal): array
    {
        $rentang = $this->kelompokkanRentang($tanggal);
        $hariIni = Carbon::today();

        $aktif = $rentang
            ->filter(fn ($r) => $r['selesai']->gte($hariIni))
            ->values();

        $riwayat = $rentang
            ->filter(fn ($r) => $r['selesai']->lt($hariIni))
            ->sortByDesc(fn ($r) => $r['mulai']->timestamp)
            ->values();

        return [$aktif, $riwayat];
    }

    /**
     * Menggabungkan tanggal berurutan yang beralasan sama menjadi satu rentang,
     * supaya blokir dua minggu tampil sebagai satu baris dan bukan 14 kotak.
     */
    private function kelompokkanRentang(Collection $tanggal): Collection
    {
        $urut = $tanggal->sortBy(fn ($d) => $d->tanggal->timestamp)->values();
        $hasil = collect();
        $grup = null;

        foreach ($urut as $baris) {
            $bersambung = $grup
                && $baris->alasan === $grup['alasan']
                && $baris->tanggal->copy()->subDay()->isSameDay($grup['selesai']);

            if ($bersambung) {
                $grup['selesai'] = $baris->tanggal->copy();
                $grup['jumlah']++;
                $grup['ids'][] = $baris->id;

                continue;
            }

            if ($grup) {
                $hasil->push($grup);
            }

            $grup = [
                'mulai'   => $baris->tanggal->copy(),
                'selesai' => $baris->tanggal->copy(),
                'jumlah'  => 1,
                'alasan'  => $baris->alasan,
                'label'   => $baris->label_alasan,
                'ids'     => [$baris->id],
            ];
        }

        if ($grup) {
            $hasil->push($grup);
        }

        return $hasil;
    }

    public function addBlockedDate(Request $request, Koleksi $koleksi)
    {
        $data = $request->validate([
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'alasan'          => 'required|in:'.implode(',', array_keys(KoleksiUnavailableDate::ALASAN)),
        ]);

        $mulai = Carbon::parse($data['tanggal_mulai']);
        $selesai = isset($data['tanggal_selesai'])
            ? Carbon::parse($data['tanggal_selesai'])
            : $mulai->copy();

        $baru = 0;
        for ($d = $mulai->copy(); $d->lte($selesai); $d->addDay()) {
            $sudahAda = $koleksi->unavailableDates()
                ->whereDate('tanggal', $d->format('Y-m-d'))
                ->exists();

            if (! $sudahAda) {
                $koleksi->unavailableDates()->create([
                    'tanggal' => $d->format('Y-m-d'),
                    'alasan'  => $data['alasan'],
                ]);
                $baru++;
            }
        }

        $label = KoleksiUnavailableDate::ALASAN[$data['alasan']];

        // Barang yang terjual tidak akan kembali, jadi itemnya dinonaktifkan
        // seluruhnya, bukan sekadar diblokir pada rentang tanggal tertentu.
        if ($data['alasan'] === 'dijual') {
            $koleksi->update(['tersedia' => false]);

            return back()->with('success',
                "\"{$koleksi->nama_koleksi}\" marked as Sold and deactivated, so it no longer appears on any date.");
        }

        return back()->with('success',
            $baru === 1
                ? "1 date marked unavailable ({$label})."
                : "{$baru} dates marked unavailable ({$label}).");
    }

    public function removeBlockedDate(Koleksi $koleksi, KoleksiUnavailableDate $date)
    {
        $date->delete();

        return back()->with('success', 'Date removed from the blocked list.');
    }

    /** Melepas satu rentang sekaligus, bukan satu per satu tanggal. */
    public function removeRange(Request $request, Koleksi $koleksi)
    {
        $data = $request->validate(['ids' => 'required|string']);

        $ids = collect(explode(',', $data['ids']))
            ->map(fn ($v) => (int) trim($v))
            ->filter()
            ->all();

        $jumlah = $koleksi->unavailableDates()->whereIn('id', $ids)->delete();

        return back()->with('success',
            $jumlah === 1
                ? '1 date removed from the blocked list.'
                : "{$jumlah} dates removed from the blocked list.");
    }

    /** Membersihkan seluruh tanggal yang sudah terlewat. */
    public function clearHistory(Koleksi $koleksi)
    {
        $jumlah = $koleksi->unavailableDates()
            ->whereDate('tanggal', '<', Carbon::today())
            ->delete();

        return redirect()
            ->route('koleksi.edit', $koleksi)
            ->with('success', "History cleared ({$jumlah} past dates removed).");
    }
}
