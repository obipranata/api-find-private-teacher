<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::query()->where("email", $request->input("email"))->first();

        // cek user
        if ($user == null) {
            return response()->json([
                "status" => false,
                "message" => "email tidak ditemukan",
                "data" => null
            ]);
        }

        // cek password
        if (!Hash::check($request->input("password"), $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "password salah!!",
                "data" => null
            ]);
        }

        // create token
        $token = $user->createToken("auth_token");

        return response()->json([
            "status" => true,
            "message" => "Berhasil",
            "data" => [
                "auth" => [
                    "token" => $token->plainTextToken,
                    "token_type" => 'Bearer'
                ],
                "user" => $user
            ]
        ]);
    }

    public function getUser(Request $request)
    {
        $user = $request->user();
        return response()->json([
            "status" => true,
            "message" => "",
            "data" => $user
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $password = $request->input('password');
        if (!isset($password)) {
            $payload = $request->except(['password']);
        } else {
            $payload = $request->all();
        }


        $user = User::query()->where('id', $id)->first();

        if ($user) {
            $user->update($payload);
            return response()->json([
                "status" => true,
                "message" => "data berhasil di update",
                "data" => $user
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "data gagal diupdate",
            "data" => null
        ]);
    }
}
