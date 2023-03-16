<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peminjamanM extends Model
{
    use HasFactory;

    protected $table = 'Peminjaman';
    protected $fillable = [
        'id_buku',
        'id_user',
        'tanggal_pinjam',
        'tanggal_kembali',
        'denda',
    ];
}
