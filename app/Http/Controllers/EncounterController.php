<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class EncounterController extends Controller
{
    public function encounter(Request $request)
    {
        $units = Unit::whereIn('kelas_unit', ['1'])
            ->orderBy('nama_unit', 'asc')
            ->pluck('nama_unit', 'kode_unit');
        return view('simrs.encounter_index', compact('units', 'request'));
    }
}
