<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga_paket extends Model
{
    use HasFactory;
    public $guarded = ["id"];
    protected $table = "harga_paket";

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(Mata_pelajaran::class, 'id_mata_pelajaran');
    }

    public function detailPemesanan()
    {
        return $this->belongsTo(Detail_pemesanan::class, 'id');
    }
}
