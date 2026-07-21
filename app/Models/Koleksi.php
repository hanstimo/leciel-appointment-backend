<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Koleksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_koleksi',
        'kategori',
        'deskripsi',
        'foto',
        'tersedia',
    ];

    protected $casts = [
    'tersedia' => 'boolean',
];

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_koleksi');
    }

    public function unavailableDates()
{
    return $this->hasMany(KoleksiUnavailableDate::class);
}
}