<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Exception;

class HomeController extends Controller
{
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

    public function checkConnection()
    {
        try {
            DB::connection('mysql2')->getPdo();
            return response()->json(['status' => 'success', 'message' => 'Database connection is alive']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Database connection is dead']);
        }
    }
}
