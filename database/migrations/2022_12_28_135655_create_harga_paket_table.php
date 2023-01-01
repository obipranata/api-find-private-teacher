<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_paket', function (Blueprint $table) {
            $table->id();
            $table->integer("id_kelas");
            $table->integer("id_mata_pelajaran");
            $table->integer("id_guru");
            $table->integer("harga");
            $table->integer("durasi_belajar");
            $table->integer("jumlah_pertemuan");
            $table->string("thumbnail", 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('harga_paket');
    }
};
