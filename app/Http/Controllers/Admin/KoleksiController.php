<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Koleksi;
use App\Models\KoleksiUnavailableDate;
use Illuminate\Http\Request;

class KoleksiController extends Controller
{
    public function index(Request $request)
    {
        $koleksis = Koleksi::orderBy('kategori')->orderBy('nama_koleksi')->get();

        return view('koleksi.index', compact('koleksis'));
    }

    public function toggleTersedia(Koleksi $koleksi)
    {
        $koleksi->update(['tersedia' => !$koleksi->tersedia]);

        return back()->with('success', "Status ketersediaan \"{$koleksi->nama_koleksi}\" diperbarui.");
    }

    public function edit(Koleksi $koleksi)
{
    $koleksi->load('unavailableDates');

    return view('koleksi.edit', compact('koleksi'));
}

public function addBlockedDate(Request $request, Koleksi $koleksi)
{
    $data = $request->validate([
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
    ]);

    $mulai = \Carbon\Carbon::parse($data['tanggal_mulai']);
    $selesai = isset($data['tanggal_selesai']) ? \Carbon\Carbon::parse($data['tanggal_selesai']) : $mulai;

    for ($date = $mulai->copy(); $date->lte($selesai); $date->addDay()) {
        $sudahAda = $koleksi->unavailableDates()
            ->whereDate('tanggal', $date->format('Y-m-d'))
            ->exists();

        if (! $sudahAda) {
            $koleksi->unavailableDates()->create(['tanggal' => $date->format('Y-m-d')]);
        }
    }

    return back()->with('success', 'Tanggal berhasil ditandai tidak tersedia.');
}

public function removeBlockedDate(Koleksi $koleksi, KoleksiUnavailableDate $date)
{
    $date->delete();

    return back()->with('success', 'Tanggal dihapus dari daftar blokir.');
}
}