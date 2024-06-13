<?php

namespace App\Http\Controllers\IGD\Penunjang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarPenunjangController extends Controller
{
    public function index()
    {
        return view('simrs.igd.daftar_penunjang.index');
    }
}
