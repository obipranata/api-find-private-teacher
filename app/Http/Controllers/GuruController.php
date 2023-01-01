<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::query()->get();


        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $guru
        ]);
    }

    public function show($id)
    {
        $guru = Guru::with(['hargaPaket'])->where("id_user", $id)->first();
        if ($guru == null) {
            return response()->json([
                "status" => false,
                "message" => "Guru tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Data berhasil didapatkan",
            "data" => $guru
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
        $user->role = 1;
        $user->save();

        $payload['id_user'] = $user->id;

        if (!isset($payload["no_hp"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada no_hp",
                "data" => null
            ], 411);
        }

        if (!isset($payload["pendidikan_terakhir"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada pendidikan terakhir",
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

        if (!isset($payload["foto"])) {
            return response()->json([
                "status" => false,
                "message" => "wajib ada foto",
                "data" => null
            ], 411);
        }

        $payload['foto'] = $request->file('foto')->store('guru', 'public');

        $guru = Guru::query()->create($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil disimpan",
            "data" => $guru
        ]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        $guru = Guru::find($id);
        if (!$guru) {
            return response()->json([
                "status" => false,
                "message" => "guru tidak ditemukan",
                "data" => null
            ], 404);
        }

        // cek jika ada perubahan pada file foto
        if (isset($request->foto)) {
            // hapus file lama pada storage guru
            Storage::disk('public')->delete($guru->foto);

            // simpan foto baru pada storage guru
            $payload['foto'] = $request->foto->store('guru', 'public');
        }

        $guru->update($payload);
        return response()->json([
            "status" => true,
            "message" => "Data berhasil update",
            "data" => $guru
        ]);
    }

    public function destroy($id)
    {
        $guru = Guru::find($id);
        if (!$guru) {
            return response()->json([
                "status" => false,
                "message" => "guru tidak ditemukan",
                "data" => null
            ]);
        }

        $guru->delete();
        return response()->json([
            "status" => true,
            "message" => "Data berhasil dihapus",
        ]);
    }
}
