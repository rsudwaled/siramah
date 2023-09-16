<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->email_verified_at == null) {
            Log::warning("Akun belum diverifikasi " . $user->name . ' , ' . $user->email);
            auth()->logout();
            return redirect()->route('login')->withErrors("Mohon maaf, akun anda belum diverifikasi.");
        }
        return view('home');
    }
    public function landingpage()
    {
        $jadwal = JadwalDokter::get();
        return view('vendor.medilab.landingpage', compact([
            'jadwal'
        ]));
    }
}
