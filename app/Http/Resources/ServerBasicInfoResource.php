<?php

namespace App\Http\Resources;

use App\Http\Controllers\Traits\HasSlug;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServerBasicInfoResource extends JsonResource {
    use HasSlug;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $server = [];
        $server['serverUrl'] = route(
            "server.info", [
                "address" => $this->address_game,
                "slug" => self::getSlug($this->name)
            ]);
        if(property_exists($this->variables, "mapname")) {
            $server['mapUrl'] = route("map.info", [
                "name" => self::urlEncodeRouteParam($this->variables->mapname)
            ]);
            $server['mapName'] = $this->variables->mapname;
        }
        $server['playersOnline'] = $this->variables->numplayers;
        $server['playersMax'] = $this->variables->maxplayers;
        $server['name'] = $this->name;
        $server['addressGame'] = $this->address_game;
        $server['ratingMinute'] = $this->rating_minute;
        $server['gamemodeTags'] = $this->getGamemodeInfo();

        return $server;

    }

    
    private static function urlEncodeRouteParam($paramValue) {
        return str_replace(["{","}"], ["%7B", "%7D"], $paramValue);
    }
}
