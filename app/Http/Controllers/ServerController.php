<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Server;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;


class ServerController extends Controller {
    public function showList(): View {
        return view('serverlist', [
            'servers' => $this->getOnlineServerList()->get()
        ]);
    }

    private function getOnlineServerList() {
        $timeLowerBoundary = Carbon::now()->subHours(1);
        return Server::where('last_success', '>', $timeLowerBoundary);
    }

    public function listPagination() {
        $servers = $this->
            getOnlineServerList()->
            select("id", "name", "variables", "rating_minute", "country")->
            orderByDesc("rating_minute");

        return $servers->paginate(30);
    }
    
}
