<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $unit = Unit::with(['lokasi'])->get();
        return view('simrs.unit_index', compact(['unit']));
    }
}
