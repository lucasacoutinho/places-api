<?php

namespace App\Models;

use App\Helpers\PlaceHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $table = 'places';

    protected $fillable = [
        'name',
        'slug',
        'city',
        'state',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $place) {
            $placeHelper = app(PlaceHelper::class);
            $place->slug = $placeHelper->slug($place->name, $place->city, $place->state);
        });

        static::updating(function (self $place) {
            $placeHelper = app(PlaceHelper::class);
            $place->slug = $placeHelper->slug($place->name, $place->city, $place->state);
        });
    }
}
