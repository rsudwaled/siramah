<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendaftaranPasienIGDController extends Controller
{
    public function pilihPasienPendaftaran()
    {
        return view('simrs.igd.pendaftaran.pilih_pendaftaran');
    }
}
