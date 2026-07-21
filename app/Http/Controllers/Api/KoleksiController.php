<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Koleksi;
use Illuminate\Http\Request;

class KoleksiController extends Controller
{
   public function index(Request $request)
{
    $tanggal = $request->query('tanggal');

    $koleksis = Koleksi::with(['unavailableDates' => function ($q) use ($tanggal) {
        if ($tanggal) {
            $q->whereDate('tanggal', $tanggal);
        }
    }])->get();

    return $koleksis->map(function ($koleksi) use ($tanggal) {
        $blocked = $tanggal && $koleksi->unavailableDates->isNotEmpty();

        return [
            'id' => $koleksi->id,
            'nama_koleksi' => $koleksi->nama_koleksi,
            'kategori' => $koleksi->kategori,
            'deskripsi' => $koleksi->deskripsi,
            'foto' => $koleksi->foto,
            'tersedia' => $koleksi->tersedia && !$blocked,
        ];
    });
}
}