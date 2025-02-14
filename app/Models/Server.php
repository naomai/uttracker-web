<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Server extends Model
{
    use HasFactory;

    protected $hidden = ['variables'];

    protected function variables(): Attribute
    {
        return Attribute::make(
            get: fn (string $json) => json_decode($json),
            set: fn (object $obj) => json_encode($obj),
        );
    }

    public function playerStats() : HasMany {
        return $this->hasMany(PlayerStat::class);
    }
}
