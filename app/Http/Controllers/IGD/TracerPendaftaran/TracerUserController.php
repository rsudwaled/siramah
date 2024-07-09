<?php

namespace App\Http\Controllers\IGD\TracerPendaftaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Kunjungan;
use Illuminate\Support\Carbon;
class TracerUserController extends Controller
{
    public function index(Request $request)
    {
        // $user = auth()->user()->userSimrs?->id??1140;
        $userList = User::whereIn('id_simrs', ['1387','1272','1056','1388','221','214','69','1140','79','1055','77','61','1341','223','215','72','1098'])->get(); 
        if(!empty($request->user_pendaftaran) && !empty($request->start) && !empty($request->end))
        {
            $userPendaftaran = User::whereIn('id', [$request->user_pendaftaran])->get();
        }else{
            $userPendaftaran = User::whereIn('id_simrs', ['1387','1272','1056','1388','221','214','69','1140','79','1055','77','61','1341','223','215','72','1098'])->get();
        }
        return view('simrs.igd.tracer_user_pendaftaran.index', compact('userPendaftaran','request','userList'));
    }
}
