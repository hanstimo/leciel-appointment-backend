<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'no_telepon' => 'nullable|string|max:20',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'catatan' => 'nullable|string',
            'koleksi_ids' => 'array',
            'koleksi_ids.*' => 'exists:koleksis,id',
        ]);

        $pelanggan = Pelanggan::firstOrCreate(
            ['email' => $data['email']],
            [
                'nama' => $data['nama'],
                'no_telepon' => $data['no_telepon'] ?? null,
                'sumber' => 'web',
            ]
        );

        $appointment = Appointment::create([
            'pelanggan_id' => $pelanggan->id,
            'tanggal' => $data['tanggal'],
            'jam' => $data['jam'],
            'status' => 'menunggu',
            'catatan' => $data['catatan'] ?? null,
        ]);

        if (!empty($data['koleksi_ids'])) {
            $appointment->koleksis()->attach($data['koleksi_ids']);
        }

        return response()->json(
            $appointment->load('koleksis', 'pelanggan'),
            201
        );
    }

    public function index(Request $request)
    {
        $pelanggan = $request->user();

        $appointments = $pelanggan->appointments()
            ->with('koleksis')
            ->orderByDesc('tanggal')
            ->get();

        return response()->json($appointments);
    }
}