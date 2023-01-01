<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga_paket;
use App\Models\Guru;
use Illuminate\Support\Facades\Storage;

class HargaPaketController extends Controller
{
    private $id_guru = 0;
    private $getPaketGuru  = [];
    public function index()
    {
        $harga_paket = Harga_paket::with(['guru', 'mataPelajaran', 'kelas'])->get();

        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $harga_paket
        ]);
    }

    public function show($id)
    {
        $harga_paket = Harga_paket::with(['guru', 'mataPelajaran', 'kelas'])->where("id", $id)->first();
        if ($harga_paket == null) {
            return response()->json([
                "status" => false,
                "message" => "data tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $harga_paket
        ]);
    }

    public function byGuru(Request $request)
    {
        $user = $request->user();
        $guru = Guru::query()->where('id_user', $user->id)->first();
        $this->id_guru = $guru->id;

        $harga_paket = Harga_paket::with(['guru', 'mataPelajaran', 'kelas'])->get();

        $collection = $harga_paket->map(function ($paket) {
            if ($paket->guru->id == $this->id_guru) {
                $this->getPaketGuru[] = $paket;
            }
        })->reject(function ($paket) {
            return empty($paket);
        });

        if ($harga_paket == null) {
            return response()->json([
                "status" => false,
                "message" => "data tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $this->getPaketGuru
        ]);
    }

    public function store(Request $request)
    {
        $payload = $request->all();
        if (!isset($payload["id_kelas"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada id kelas",
                "data" => null
            ], 411);
        }
        if (!isset($payload["id_mata_pelajaran"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada id mata pelajaran",
                "data" => null
            ], 411);
        }
        if (!isset($payload["id_guru"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada id guru",
                "data" => null
            ], 411);
        }

        if (!isset($payload["harga"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada harga",
                "data" => null
            ], 411);
        }

        if (!isset($payload["durasi_belajar"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada durasi belajar",
                "data" => null
            ], 411);
        }

        if (!isset($payload["jumlah_pertemuan"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada jumlah pertemuan",
                "data" => null
            ], 411);
        }

        if (!isset($payload["thumbnail"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada thumbnail",
                "data" => null
            ], 411);
        }

        $payload['thumbnail'] = $request->file('thumbnail')->store('harga_paket', 'public');

        $harga_paket = Harga_paket::query()->create($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil disimpan",
            "data" => $harga_paket
        ]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        $harga_paket = Harga_paket::find($id);
        if (!$harga_paket) {
            return response()->json([
                "status" => false,
                "message" => "harga paket tidak ditemukan",
                "data" => null
            ], 404);
        }

        if (isset($request->thumbnail)) {
            Storage::disk('public')->delete($harga_paket->thumbnail);

            $payload['thumbnail'] = $request->thumbnail->store('harga_paket', 'public');
        }

        $harga_paket->update($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil update",
            "data" => $harga_paket
        ]);
    }

    public function destroy($id)
    {
        $harga_paket = Harga_paket::find($id);
        if (!$harga_paket) {
            return response()->json([
                "status" => false,
                "message" => "harga paket tidak ditemukan",
                "data" => null
            ]);
        }

        Storage::disk('public')->delete($harga_paket->thumbnail);

        $harga_paket->delete();
        return response()->json([
            "status" => true,
            "message" => "Data berhasil dihapus",
        ]);
    }
}
