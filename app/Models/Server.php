<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Server extends Model
{
    use HasFactory;

    protected function variables(): Attribute
    {
        return Attribute::make(
            get: fn (string $json) => json_decode($json),
            set: fn (object $obj) => json_encode($obj),
        );
    }
}
