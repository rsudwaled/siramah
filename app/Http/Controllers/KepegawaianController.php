<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KepegawaianController extends Controller
{
    public function vData(Request $request)
    {
        return view('simrs.kepeg.datakepeg.index', compact('request'));
    }
}
