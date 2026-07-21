<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email',
            'no_telepon' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'no_telepon' => $data['no_telepon'] ?? null,
            'sumber' => 'web',
            'password' => $data['password'],
        ]);

        $token = $pelanggan->createToken('customer-token')->plainTextToken;

        return response()->json([
            'pelanggan' => $pelanggan,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $pelanggan = Pelanggan::where('email', $data['email'])->first();

        if (!$pelanggan || !$pelanggan->password || !Hash::check($data['password'], $pelanggan->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $token = $pelanggan->createToken('customer-token')->plainTextToken;

        return response()->json([
            'pelanggan' => $pelanggan,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Berhasil logout']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}