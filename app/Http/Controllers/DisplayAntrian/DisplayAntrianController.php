<?php

namespace App\Http\Controllers\DisplayAntrian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AntrianFarmasiDP;

class DisplayAntrianController extends Controller
{
    public function farmasi(){
        $antrian_depo           = AntrianFarmasiDP::orderBy('tgl_antrian','asc')->get();
        $reguler_antrian_depo   = AntrianFarmasiDP::where('status_antrian',0)->where('jenis_antrian','REGULER')->get();
        $racikan_antrian_depo   = AntrianFarmasiDP::where('status_antrian',0)->where('jenis_antrian','RACIKAN')->get();
        return view('simrs.display_antrian.index',compact('antrian_depo','reguler_antrian_depo', 'racikan_antrian_depo'));
    }
}
