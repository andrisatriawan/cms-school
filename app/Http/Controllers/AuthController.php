<?php

namespace App\Http\Controllers;

use App\Models\Sliders;
use Exception;
use Faker\Provider\UserAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use GeoIP;

class AuthController extends Controller
{
    use LogsActivity;

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        $sliders = Sliders::offset(0)->limit(3)->orderBy('created_at', 'desc')->get();

        return view('back.auth.login', compact('sliders'));
    }

    public function auth(Request $request)
    {
        $authIdentitas = [
            'email' =>  $request->username,
            'password' => $request->password,
        ];
        try {
            $attemptLogin = Auth::attempt($authIdentitas);

            if (!$attemptLogin) {
                throw new Exception('Username atau password salah!');
            }
            $user = auth()->user();

            $this->logAuthenticatedAttempt($request, $user);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Login!',
                'redirect' => route('admin.dashboard')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('auth.login');
    }

    protected function logAuthenticatedAttempt(Request $request, $user)
    {
        $ip = $request->ip();

        $geoIP = GeoIP::getLocation($ip);
        $agent = new Agent();

        $city = $geoIP->city;
        $country = $geoIP->country;
        $browser = $agent->browser();

        activity()
            ->causedBy($user)
            ->withProperties([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'country' => $country,
                'city' => $city,
                'browser' => $browser
            ])
            ->log('User successfully authenticated');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('autentikasi')
            ->logFillable();
    }
}
