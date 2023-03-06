<?php

use App\Http\Controllers\CiudadanoController;
use App\Http\Controllers\ComunaController;
use App\Http\Controllers\ConcejoController;
use App\Http\Controllers\InfanteController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ParroquiaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
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
    Route::get('/dashboard', [LogController::class, 'dashboard'])->name('dashboard');

    Route::get('/', [LogController::class, 'dashboard']);

    Route::get('notifications/get', [LogController::class, 'notifications'])->name('notifications.get');

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

    Route::get('ciudadano/excel', [CiudadanoController::class, 'export'])->name('ciudadanos.excel');
    Route::get('ciudadano/csv', [CiudadanoController::class, 'csv'])->name('ciudadanos.csv');

});
