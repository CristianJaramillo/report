<?php

use Report\Managers\AuthManager;

class AuthController extends BaseController {

    public function login()
    {

        $manager = new AuthManager(Input::all());

        if ($manager->save())
        {
            return Redirect::route('account', ['user' => Str::slug(Auth::user()->full_name)]);
        }

        Session::flash('message', 'login-error');

        return Redirect::back();

    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('sing-in');
    }

} 