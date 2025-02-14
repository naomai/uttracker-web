<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServerController;
use App\Models\Server;

Route::get('/', [ServerController::class, 'showList']);

Route::get('/server/{address}-{slug}', function (string $address, string $slug) {
    $server = Server::where("address_game", "=", $address)->first();
    return view('serverinfo', ['server'=>$server]);
})
->where(['address' => '([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}|[a-z\-][a-z0-9\-\.]*)\:[0-9]{1,5}'])
->name("server.info");

Route::get('/player/{slug}', function (string $playerSlug) {
    return view('player.info');
})
->name("player.info");


Route::get('/map/{name}', function (string $mapName) {
    return view('map.info');
})
->name("map.info");



Route::get('/servers', [ServerController::class, 'list'])->name('server.list');
