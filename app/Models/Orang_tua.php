<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orang_tua extends Model
{
    use HasFactory;
    public $guarded = ["id"];
    protected $table = "orang_tua";

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'id');
    }
}
