<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Map;

class HomeController extends Controller
{
    public function index(){
        $data['map_data'] = Map::all();
        return view('app', $data);
    }
}
