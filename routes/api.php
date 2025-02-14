<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Server;
use App\Http\Controllers\ServerController;

Route::get('/servers', [ServerController::class, 'listPagination'])->name('api.server.list');
Route::get('/server_stats/{server}', [ServerController::class, 'showPlayerStats'])
    ->name('api.server.playerstats');