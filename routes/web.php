<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServerController;
use App\Models\Server;

Route::get('/', [ServerController::class, 'showList']);

Route::get('/server/{address}-{slug}', function (string $address, string $slug) {
    return view('server');
})->where(['address' => '([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}|[a-z\-][a-z0-9\-\.]*)\:[0-9]{1,5}']);

Route::get('/player/{slug}', function (string $playerSlug) {
    return view('player');
});

Route::get('/map/{name}', function (string $mapName) {
    return view('map');
});



Route::get('/servers', [ServerController::class, 'list'])->name('servers.list');
