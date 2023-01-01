<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;
    public $guarded = ["id"];
    protected $table = "pemesanan";

    public function orangTua()
    {
        return $this->belongsTo(Orang_tua::class, 'id_orang_tua');
    }

    public function detailPemesanan()
    {
        return $this->hasMany(Detail_pemesanan::class, "id");
    }
}
