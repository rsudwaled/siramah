<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends APIController
{
    public function index()
    {
        $unit = Unit::with(['lokasi'])->get();
        return view('simrs.unit_index', compact(['unit']));
    }
    public function data_unit_rajal()
    {
        $data = Unit::where('KDPOLI', '!=', null)->get();
        return $this->sendResponse($data, 200);
    }
}
