<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HasSlug;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Server;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;


class ServerController extends Controller {
    use HasSlug;
    
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
            select("id", "address", "name", "variables", "rating_minute", "country")->
            orderByDesc("rating_minute");
        
        $serversCollection = $servers->paginate(30);
        $serversCollection->getCollection()->transform(function($server){
            $server->serverUrl = route(
                "server.info", 
                [
                    "address"=>$server->address,
                    "slug"=>self::getSlug($server->name)
                ]);
            $server->mapUrl = route("map.info", ["name"=>$server->variables->mapname]);
            $server->mapName = $server->variables->mapname;
            $server->playersOnline = $server->variables->numplayers;
            $server->playersMax = $server->variables->maxplayers;
            unset($server->variables);
            return $server;
        });
        
        return $serversCollection;

    }
    
}
