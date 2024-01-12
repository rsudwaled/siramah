<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        try {
            $user_google    = Socialite::driver('google')->user();
            $user           = User::firstWhere('email', $user_google->email);
            //jika user ada maka langsung di redirect ke halaman home
            if ($user) {
                $user->update([
                    'email' => $user_google->email,
                    'name' => $user_google->name,
                    'google_id' => $user_google->id,
                    'avatar' => $user_google->avatar,
                    'avatar_original' => $user_google->avatar_original,
                ]);
            }
            //jika user tidak ada maka simpan ke database
            else {
                //$user_google menyimpan data google account seperti email, foto, dsb
                $user = User::Create([
                    'email' => $user_google->email,
                    'name' => $user_google->name,
                    'password' => Hash::make('password'),
                    'google_id' => $user_google->id,
                    'avatar' => $user_google->avatar,
                    'avatar_original' => $user_google->avatar_original,
                ]);
                $user->assignRole('Pasien');
                Log::notice('Daftar Akun Gmail ' . $user_google->name . ' , ' . $user_google->email);
                $request = new Request();
                $wa = new WhatsappController();
                $request['notif'] = "*Login akun gmail SIRAMAH-RS WALED* \nTelah mencoba login sistem dengan data sebagai berikut.\n\nNAMA : " . $user_google->name . "\nEMAIL : " . $user_google->email . "\n\nMohon segera lakukan verifikasi login tersebut.\nsiramah.rsudwaled.id";
                $wa->send_notif($request);
            }
            if ($user->email_verified_at) {
                auth()->login($user, true);
                Log::info('Percobaan Login Gmail ' . $user_google->name . ' , ' . $user_google->email);
                return redirect()->route('home');
            } else {
                Log::warning("Akun belum diverifikasi " . $user_google->name . ' , ' . $user_google->email);
                return redirect()->route('login')->withErrors("Mohon maaf, akun anda belum diverifikasi. Silahkan meminta verifikasi akun oleh Tim IT.");
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors("Mohon maaf, " . $e->getMessage());
        }
    }
}
