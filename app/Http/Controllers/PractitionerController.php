<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Paramedis;
use Illuminate\Http\Request;

class PractitionerController extends Controller
{
    public function index(Request $request)
    {
        $paramedis = Paramedis::get();
        $dokter = Dokter::get();
        return view('simrs.practitioner_index', compact([
            'request',
            'dokter',
            'paramedis',
        ]));
    }
}
