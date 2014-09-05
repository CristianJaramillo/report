<?php

use Report\Managers\AuthManager;

class AuthController extends BaseController {

    public function login()
    {

        $manager = new AuthManager(Input::all());
        
        if ($manager->save())
        {
            return Redirect::route('account', ['user' => Str::slug(Auth::user()->full_name)]);
        } else {
            return App::abort(404);
        }

    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('sing-in');
    }

} 