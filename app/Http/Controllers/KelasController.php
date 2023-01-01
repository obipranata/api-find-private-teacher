<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::query()->get();


        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $kelas
        ]);
    }

    public function show($id)
    {
        $kelas = Kelas::query()->where("id", $id)->first();
        if ($kelas == null) {
            return response()->json([
                "status" => false,
                "message" => "kelas tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $kelas
        ]);
    }

    public function store(Request $request)
    {
        $payload = $request->all();

        if (!isset($payload["nama_kelas"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada nama kelas",
                "data" => null
            ], 411);
        }

        $kelas = Kelas::query()->create($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil disimpan",
            "data" => $kelas
        ]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        $kelas = Kelas::find($id);
        if (!$kelas) {
            return response()->json([
                "status" => false,
                "message" => "kelas tidak ditemukan",
                "data" => null
            ], 404);
        }

        $kelas->update($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil update",
            "data" => $kelas
        ]);
    }

    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        if (!$kelas) {
            return response()->json([
                "status" => false,
                "message" => "kelas tidak ditemukan",
                "data" => null
            ]);
        }

        $kelas->delete();
        return response()->json([
            "status" => true,
            "message" => "Data berhasil dihapus",
        ]);
    }
}
