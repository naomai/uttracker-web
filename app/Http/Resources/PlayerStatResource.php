<?php

namespace App\Http\Resources;

use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerStatResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        $onlineTime = CarbonInterval::seconds($this->game_time);
        $stat = [
            //'playerId' => $this->player_id,
            'country' => $this->player->country,
            'slug' => $this->player->slug,
            'name' => $this->player->name,
            'gameTime' => $this->game_time,
            'gameTimeFormatted' => $onlineTime->cascade()->forHumans([
                'short' => true,
                'parts' => 2,
                'minimumUnit' => "minute",
            ]),
            'score' => $this->score,
            'deaths' => $this->deaths,
            'lastMatchId' => $this->last_match_id,
        ];
        return $stat;
    }
}
