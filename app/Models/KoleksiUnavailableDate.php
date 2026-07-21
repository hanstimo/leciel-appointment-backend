<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoleksiUnavailableDate extends Model
{
    protected $fillable = ['koleksi_id', 'tanggal'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function koleksi()
    {
        return $this->belongsTo(Koleksi::class);
    }
}