<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pemesanan extends Model
{
    use HasFactory;
    public $guarded = ["id"];
    protected $table = "detail_pemesanan";

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    public function hargaPaket()
    {
        return $this->belongsTo(Harga_paket::class, 'id_harga_paket');
    }
}
