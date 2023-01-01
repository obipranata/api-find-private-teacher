<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Detail_pemesanan;
use App\Models\Orang_tua;
use App\Models\Guru;

class PemesananController extends Controller
{
    private $id_orang_tua = 0;
    private $getOrderOrtu  = [];
    private $id_guru = 0;
    private $getOrderGuru  = [];
    public function index()
    {
        $pemesanan = Detail_pemesanan::with(['pemesanan.orangTua', 'hargaPaket.guru', 'hargaPaket.kelas', 'hargaPaket.mataPelajaran'])->get();
        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $pemesanan
        ]);
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::query()->where("id", $id)->first();
        if ($pemesanan == null) {
            return response()->json([
                "status" => false,
                "message" => "Pemesanan tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $pemesanan
        ]);
    }

    public function orderOrtu(Request $request)
    {
        $user = $request->user();
        $ortu = Orang_tua::query()->where('id_user', $user->id)->first();
        $this->id_orang_tua = $ortu->id;

        $pemesanan = Detail_pemesanan::with(['pemesanan.orangTua', 'hargaPaket.guru', 'hargaPaket.kelas', 'hargaPaket.mataPelajaran'])->get();

        $collection = $pemesanan->map(function ($pesan) {
            if ($pesan['pemesanan']['id_orang_tua'] == $this->id_orang_tua) {
                $this->getOrderOrtu[] = $pesan;
            }
        })->reject(function ($pesan) {
            return empty($pesan);
        });

        if ($pemesanan == null) {
            return response()->json([
                "status" => false,
                "message" => "Pemesanan tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $this->getOrderOrtu
        ]);
    }

    public function orderGuru(Request $request)
    {
        $user = $request->user();
        $guru = Guru::query()->where('id_user', $user->id)->first();
        $this->id_guru = $guru->id;

        $pemesanan = Detail_pemesanan::with(['pemesanan.orangTua', 'hargaPaket.guru', 'hargaPaket.kelas', 'hargaPaket.mataPelajaran'])->get();

        $collection = $pemesanan->map(function ($pesan) {
            if ($pesan->hargaPaket->id_guru == $this->id_guru) {
                $this->getOrderGuru[] = $pesan;
            }
        })->reject(function ($pesan) {
            return empty($pesan);
        });

        if ($pemesanan == null) {
            return response()->json([
                "status" => false,
                "message" => "Pemesanan tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $this->getOrderGuru
        ]);
    }

    public function store(Request $request)
    {
        $payload = $request->all();

        if (!isset($payload["id_orang_tua"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada id orang tua",
                "data" => null
            ], 411);
        }

        if (!isset($payload["status"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada status",
                "data" => null
            ], 411);
        }

        if (!isset($payload["id_harga_paket"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada id harga paket",
                "data" => null
            ], 411);
        }

        $pemesanan = new Pemesanan();
        $pemesanan->id_orang_tua = $payload["id_orang_tua"];
        $pemesanan->tanggal_pemesanan = now();
        $pemesanan->status = $payload["status"];
        $pemesanan->save();

        $payload['id_pemesanan'] = $pemesanan->id;

        $detail_pemesanan = Detail_pemesanan::query()->create($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil disimpan",
            "data" => $detail_pemesanan
        ]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        $pemesanan = Pemesanan::find($id);
        if (!$pemesanan) {
            return response()->json([
                "status" => false,
                "message" => "pemesanan tidak ditemukan",
                "data" => null
            ], 404);
        }

        $pemesanan->update($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil update",
            "data" => $pemesanan
        ]);
    }

    public function destroy($id)
    {
        $pemesanan = Pemesanan::find($id);
        if (!$pemesanan) {
            return response()->json([
                "status" => false,
                "message" => "pemesanan tidak ditemukan",
                "data" => null
            ]);
        }

        $pemesanan->delete();
        return response()->json([
            "status" => true,
            "message" => "Data berhasil dihapus",
        ]);
    }
}
