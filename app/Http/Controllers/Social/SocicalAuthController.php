<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SocicalAuthController extends Controller
{
    public function login()
    {
        return view('Auth/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {

            $user     = Socialite::driver($provider)->user();
            $findUser = User::where('provider_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect('/profile');
            } else {
                $url = $user->avatar;
                $info = pathinfo($url);
                $contents = file_get_contents($url);
                $name = time(). $info['basename'];
                $file = public_path() . '/images/'. $name;
                file_put_contents($file, $contents);

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'provider_id' => $user->id,
                    'provider' => $provider,
                    'avatar' => $name,
                    'password' => ''
                ]);
                Auth::login($newUser);

                return redirect('/profile');
            }

        } catch (Exception $e) {
            return redirect('auth/' . $provider);
        }
    }

    public function profile()
    {
        $user = Auth::user()->toArray();
        return view('Auth/profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if($request->hasFile('avatar')){

            $image = $request->avatar->getClientOriginalName();
            $request->avatar->move('images', $image);
            $user->avatar = $image;
        }
        $user->email =$request->email;
        $user->name = $request->name;
        $user->phone = $request->phone;
        if($user->save()){
            return redirect()->back()->with('success','update success');
        };
        return redirect()->back()->with('error','update error');
    }
}
