<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mata_pelajaran extends Model
{
    use HasFactory;
    public $guarded = ["id"];
    protected $table = "mata_pelajaran";

    public function hargaPaket()
    {
        return $this->hasMany(Harga_paket::class, 'id');
    }
}
