<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RuletaController extends Controller
{
    public function index()
    {
        return view('ruleta.index');
    }
}
