<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    public $guarded = ["id"];
    protected $table = "guru";

    public function hargaPaket()
    {
        return $this->hasMany(Harga_paket::class, 'id');
    }
}
