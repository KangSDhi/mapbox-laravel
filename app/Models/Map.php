<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class Map extends Model
{
    use HasFactory, HasSpatial;

    protected $table = 'map';

    protected $fillable = [
        'nama_map',
        'area_map',
        'background_map',
    ];

    protected $casts = [
        'area_map'  => Polygon::class,
    ];
}
