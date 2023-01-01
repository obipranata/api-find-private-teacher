<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\HargaPaketController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PemesananController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("/login", [AuthController::class, "login"])->name("login");
Route::get("/me", [AuthController::class, "getUser"])->middleware(["auth:sanctum"]);
Route::post("/user/{id}/update", [AuthController::class, "updateUser"])->middleware(["auth:sanctum"]);

Route::get("/guru", [GuruController::class, "index"]);
Route::get("/guru/{id}", [GuruController::class, "show"]);
Route::post("/guru", [GuruController::class, "store"]);
Route::post("/guru/{id}/edit", [GuruController::class, "update"])->middleware(["auth:sanctum", "guru"]);
Route::post("/guru/{id}/delete", [GuruController::class, "destroy"])->middleware(["auth:sanctum", "admin"]);

Route::get("/mapel", [MataPelajaranController::class, "index"]);
Route::get("/mapel/{id}", [MataPelajaranController::class, "show"]);
Route::post("/mapel", [MataPelajaranController::class, "store"])->middleware(["auth:sanctum", "admin"]);
Route::post("/mapel/{id}/edit", [MataPelajaranController::class, "update"])->middleware(["auth:sanctum", "admin"]);
Route::post("/mapel/{id}/delete", [MataPelajaranController::class, "destroy"])->middleware(["auth:sanctum", "admin"]);

Route::get("/kelas", [KelasController::class, "index"]);
Route::get("/kelas/{id}", [KelasController::class, "show"]);
Route::post("/kelas", [KelasController::class, "store"])->middleware(["auth:sanctum", "admin"]);
Route::post("/kelas/{id}/edit", [KelasController::class, "update"])->middleware(["auth:sanctum", "admin"]);
Route::post("/kelas/{id}/delete", [KelasController::class, "destroy"])->middleware(["auth:sanctum", "admin"]);

Route::get("/paket", [HargaPaketController::class, "index"]);
Route::get("/paket/byGuru", [HargaPaketController::class, "byGuru"])->middleware(["auth:sanctum", "guru"]);
Route::get("/paket/{id}", [HargaPaketController::class, "show"]);
Route::post("/paket", [HargaPaketController::class, "store"])->middleware(["auth:sanctum", "guru"]);
Route::post("/paket/{id}/edit", [HargaPaketController::class, "update"])->middleware(["auth:sanctum", "guru"]);
Route::post("/paket/{id}/delete", [HargaPaketController::class, "destroy"])->middleware(["auth:sanctum", "guru"]);

Route::get("/ortu", [OrangTuaController::class, "index"]);
Route::get("/ortu/{id}", [OrangTuaController::class, "show"]);
Route::post("/ortu", [OrangTuaController::class, "store"]);
Route::post("/ortu/{id}/edit", [OrangTuaController::class, "update"])->middleware(["auth:sanctum", "ortu"]);
Route::post("/ortu/{id}/delete", [OrangTuaController::class, "destroy"])->middleware(["auth:sanctum", "admin"]);

Route::get("/pemesanan", [PemesananController::class, "index"]);
Route::get("/pemesanan/orderOrtu", [PemesananController::class, "orderOrtu"])->middleware(["auth:sanctum", "ortu"]);
Route::get("/pemesanan/orderGuru", [PemesananController::class, "orderGuru"])->middleware(["auth:sanctum", "guru"]);
Route::get("/pemesanan/{id}", [PemesananController::class, "show"])->middleware(["auth:sanctum"]);
Route::post("/pemesanan", [PemesananController::class, "store"])->middleware(["auth:sanctum", "ortu"]);
Route::post("/pemesanan/{id}/edit", [PemesananController::class, "update"])->middleware(["auth:sanctum", "guru"])
;
// Route::post("/pemesanan/{id}/delete", [PemesananController::class, "destroy"]);
