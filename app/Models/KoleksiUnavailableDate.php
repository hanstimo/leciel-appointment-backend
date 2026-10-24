<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoleksiUnavailableDate extends Model
{
    /** Alasan yang sah beserta label tampilannya pada panel admin. */
    public const ALASAN = [
        'dipinjam'   => 'On loan',
        'diperbaiki' => 'In repair',
        'disewa'     => 'Rented out',
        'dijual'     => 'Sold',
    ];

    protected $fillable = ['koleksi_id', 'tanggal', 'alasan'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function koleksi()
    {
        return $this->belongsTo(Koleksi::class);
    }

    /** Label tampilan; baris lama yang belum punya alasan ditandai tanda hubung. */
    public function getLabelAlasanAttribute(): string
    {
        return self::ALASAN[$this->alasan] ?? '—';
    }
}
