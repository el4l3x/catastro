<?php

use App\Http\Controllers\CiudadanoController;
use App\Http\Controllers\ComunaController;
use App\Http\Controllers\ConcejoController;
use App\Http\Controllers\InfanteController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ParroquiaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/', function () {
        return view('dashboard');
    });

    Route::resources([
        'logs' => LogController::class,
        'roles' => RoleController::class,
        'usuarios' => UsuarioController::class,
        'comunas' => ComunaController::class,
        'concejos' => ConcejoController::class,
        'parroquias' => ParroquiaController::class,
        'ciudadanos' => CiudadanoController::class,
        'infantes' => InfanteController::class,
    ]);
});
