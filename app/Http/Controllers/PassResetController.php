<?php

namespace App\Http\Controllers;

use App\Http\Requests\PassResetRequest;
use App\Http\Requests\PassUpdateRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PassResetController extends Controller
{
    public function request()
    {
        return view('auth.passwords.email');
    }

    public function email(PassResetRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function reset()
    {
        return view('auth.passwords.reset');
    }

    public function update(PassUpdateRequest $request)
    {
        $status = Password::reset(
            $request->except('_token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
