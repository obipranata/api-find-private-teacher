<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Orang_tua;
use App\Models\User;
use Illuminate\Support\Str;

class OrangTuaController extends Controller
{
    public function index()
    {
        $ortu = Orang_tua::query()->get();
        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $ortu
        ]);
    }

    public function show($id)
    {
        $ortu = Orang_tua::query()->where("id_user", $id)->first();
        if ($ortu == null) {
            return response()->json([
                "status" => false,
                "message" => "Orang tua tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $ortu
        ]);
    }

    public function store(Request $request)
    {
        $payload = $request->all();

        if (!isset($payload["nama"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada nama",
                "data" => null
            ], 411);
        }
        if (!isset($payload["email"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada email",
                "data" => null
            ], 411);
        }
        if (!isset($payload["password"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada password",
                "data" => null
            ], 411);
        }

        $user = new User();
        $user->name = $payload["nama"];
        $user->email = $payload["email"];
        $user->password = $payload["password"];
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->role = 2;
        $user->save();

        $payload['id_user'] = $user->id;

        if (!isset($payload["no_hp"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada no_hp",
                "data" => null
            ], 411);
        }

        if (!isset($payload["alamat"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada alamat",
                "data" => null
            ], 411);
        }

        $ortu = Orang_tua::query()->create($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil disimpan",
            "data" => $ortu
        ]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        $ortu = Orang_tua::find($id);
        if (!$ortu) {
            return response()->json([
                "status" => false,
                "message" => "orang tua tidak ditemukan",
                "data" => null
            ], 404);
        }

        $ortu->update($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil update",
            "data" => $ortu
        ]);
    }

    public function destroy($id)
    {
        $ortu = Orang_tua::find($id);
        if (!$ortu) {
            return response()->json([
                "status" => false,
                "message" => "orang tua tidak ditemukan",
                "data" => null
            ]);
        }

        $ortu->delete();
        return response()->json([
            "status" => true,
            "message" => "Data berhasil dihapus",
        ]);
    }
}
