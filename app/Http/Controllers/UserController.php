<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(LoginRequest $request) {
        $credentials = $request->getCredentials();

        $username = "";
        if(!empty($credentials['username'])) {
            $username = $credentials['username'];
        } elseif(!empty($credentials['email'])) {
            $username = $credentials['email'];
        }

        if(!Auth::validate($credentials)) {
            return redirect()->to('login')->withErrors(trans('auth.failed'));
        }
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        if($user->validated != User::USER_VALIDATED) {
            return redirect()->to('login')->withErrors(trans('auth.failed'));
        }
        Auth::login($user);

        return redirect(route('display'));
    }

    public function register(RegisterRequest $request) {
        $user = new User();
        $user->username = $request->get('username');
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect(route('login'));
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }

    public function listUsers() {
        $users = User::all();
        return view('pages.users', compact('users'));
    }

    public function toggleUser($userID) {
        $user = User::where('id', $userID)->first();
        $user->validated = $user->validated == 0 ? 1 : 0;
        $user->save();
    }
}
