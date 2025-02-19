<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HasSlug;
use App\Http\Resources\PlayerStatResource;
use App\Http\Resources\ServerBasicInfoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Server;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;


class ServerController extends Controller {
    
    public function showList(): View {
        return view(
            'serverlist', [
                'servers' => $this->getOnlineServerList()->get()
            ]
        );
    }

    private function getOnlineServerList(string $gameName="ut") {
        $timeLowerBoundary = Carbon::now()->subHours(1);
        return Server::where(
            [
                ['last_success', '>', $timeLowerBoundary],
                ['game_name', '=', $gameName]
            ]
        );
    }

    public function listPagination(Request $request) {
        $servers = $this->
            getOnlineServerList()
            -> select("id", "address_game", "name", "variables", "rating_minute", "country")
            -> where("variables", "<>", "{}")
            -> orderByDesc("rating_minute");

        $servers = self::applySorting($servers, $request);

        $serversCollection = $servers->paginate(30);
        $serversCollection->transform(function($server) {
           return new ServerBasicInfoResource($server);
        });

        return $serversCollection;
    }

    public function showPlayerStats(Server $server) {
        $stats = $server->playerStats()->with('player')->orderByDesc('score');
        return PlayerStatResource::collection($stats->get());
    }

    private static function applySorting($collection, $request) {
        $sorters = $request->query('sort');
        if(is_array($sorters) && count($sorters)>0) {
            $sorter = $sorters[0];
            return $collection->reorder($sorter['field'], $sorter['dir']);
        }
        return $collection;
    }

    
}
