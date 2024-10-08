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

    private function getOnlineServerList(string $gameName="ut") {
        $timeLowerBoundary = Carbon::now()->subHours(1);
        return Server::where([
            ['last_success', '>', $timeLowerBoundary],
            ['game_name', '=', $gameName]
        ]);
    }

    public function listPagination(Request $request) {
        $servers = $this->
            getOnlineServerList()->
            select("id", "address_game", "name", "variables", "rating_minute", "country")->
            where("variables", "<>", "{}")->
            orderByDesc("rating_minute");

        $servers = self::applySorting($servers, $request);

        

        $serversCollection = $servers->paginate(30);
        $serversCollection->transform(function($server){
            $server->serverUrl = route(
                "server.info", 
                [
                    "address" => $server->address_game,
                    "slug" => self::getSlug($server->name)
                ]);
            if(property_exists($server->variables, "mapname")){
                $server->mapUrl = route("map.info", [
                    "name" => self::urlEncodeRouteParam($server->variables->mapname)
                ]);
                $server->mapName = $server->variables->mapname;
            }
            $server->playersOnline = $server->variables->numplayers;
            $server->playersMax = $server->variables->maxplayers;
            unset($server->variables);
            return $server;
        });
        

        
        return $serversCollection;

    }

    private static function applySorting($collection, $request) {
        $sorters = $request->query('sort');
        if(is_array($sorters) && count($sorters)>0){
            $sorter = $sorters[0];
            return $collection->reorder($sorter['field'], $sorter['dir']);
        }
        return $collection;
    }

    private static function urlEncodeRouteParam($paramValue) {
        return str_replace(["{","}"], ["%7B", "%7D"], $paramValue);
    }
    
}
