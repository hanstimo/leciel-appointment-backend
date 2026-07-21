<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Koleksi;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $appointments = Appointment::with(['pelanggan', 'koleksis'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->get();

        $koleksiList = Koleksi::orderBy('kategori')->get();

        return view('dashboard', [
            'appointments' => $appointments,
            'statusFilter' => $status,
            'koleksiList' => $koleksiList,
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'status' => 'required|in:menunggu,dikonfirmasi,selesai,dibatalkan',
        ]);

        $appointment->update(['status' => $data['status']]);

        return back()->with('success', 'Status appointment diperbarui.');
    }

    public function storeManual(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'catatan' => 'nullable|string',
            'koleksi_ids' => 'array',
            'koleksi_ids.*' => 'exists:koleksis,id',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $data['nama'],
            'no_telepon' => $data['no_telepon'],
            'sumber' => 'whatsapp',
        ]);

        $appointment = Appointment::create([
            'pelanggan_id' => $pelanggan->id,
            'user_id' => auth()->id(),
            'tanggal' => $data['tanggal'],
            'jam' => $data['jam'],
            'status' => 'dikonfirmasi',
            'catatan' => $data['catatan'] ?? null,
        ]);

        if (!empty($data['koleksi_ids'])) {
            $appointment->koleksis()->attach($data['koleksi_ids']);
        }

        return back()->with('success', 'Appointment VIP dari WhatsApp berhasil dicatat.');
    }
}