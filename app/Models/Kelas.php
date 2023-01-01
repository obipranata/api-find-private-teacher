<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    public $guarded = ["id"];
    protected $table = "kelas";

    public function hargaPaket()
    {
        return $this->hasMany(Harga_paket::class, 'id');
    }
}
