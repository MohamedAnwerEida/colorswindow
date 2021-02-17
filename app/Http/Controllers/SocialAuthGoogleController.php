<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use Socialite;
use Auth;

class SocialAuthGoogleController extends Controller {

    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $existUser = Customers::where('email', $googleUser->email)->first();

        if ($existUser) {

            Auth::loginUsingId($existUser->id);
        } else {
            $user = new Customers();
            $user->name = $googleUser->name;
            $user->email = $googleUser->email;
            $user->google_id = $googleUser->id;

            $user->password = md5(rand(1, 10000));
            $user->save();
            Auth::loginUsingId($user->id);
        }
        return redirect()->to('/');
    }

}
