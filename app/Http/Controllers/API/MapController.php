<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Map;

class MapController extends Controller
{
    public function getMap(){
        $data = Map::all();
        return response()->json($data, 200);
    }
}
