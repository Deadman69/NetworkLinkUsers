<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request) {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)) {
            return redirect()->to('login')->withErrors(trans('auth.failed'));
        }
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);

        return $this->authenticated($request, $user);
    }
}
