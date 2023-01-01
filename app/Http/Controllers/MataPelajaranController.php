<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mata_pelajaran;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mata_pelajaran = Mata_pelajaran::query()->get();


        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $mata_pelajaran
        ]);
    }

    public function show($id)
    {
        $mata_pelajaran = Mata_pelajaran::query()->where("id", $id)->first();
        if ($mata_pelajaran == null) {
            return response()->json([
                "status" => false,
                "message" => "mata pelajaran tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $mata_pelajaran
        ]);
    }

    public function store(Request $request)
    {
        $payload = $request->all();

        if (!isset($payload["nama"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada nama mata pelajaran",
                "data" => null
            ], 411);
        }

        $mata_pelajaran = Mata_pelajaran::query()->create($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil disimpan",
            "data" => $mata_pelajaran
        ]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        $mata_pelajaran = Mata_pelajaran::find($id);
        if (!$mata_pelajaran) {
            return response()->json([
                "status" => false,
                "message" => "mata pelajaran tidak ditemukan",
                "data" => null
            ], 404);
        }

        $mata_pelajaran->update($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil update",
            "data" => $mata_pelajaran
        ]);
    }

    public function destroy($id)
    {
        $mata_pelajaran = Mata_pelajaran::find($id);
        if (!$mata_pelajaran) {
            return response()->json([
                "status" => false,
                "message" => "mata pelajaran tidak ditemukan",
                "data" => null
            ]);
        }

        $mata_pelajaran->delete();
        return response()->json([
            "status" => true,
            "message" => "Data berhasil dihapus",
        ]);
    }
}
