<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Class AuthService
 *
 * @package App\Services
 */
class AuthService
{
    /**
     * @param  Request  $request
     *
     * @return User|null
     */
    public function loginUser(Request $request): ?User
    {
        /** @var User $user */
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return null;
        }

        $remember = $request->has('remember');

        Auth::login($user, $remember);

        return $user;
    }

    /**
     * @param  Request  $request
     */
    public function registerUser(Request $request)
    {
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = User::ROLE_USER;

        $user->save();

        event(new Registered($user));

        Auth::login($user);
    }

    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function resetPassword(Request $request)
    {
        return Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),

            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
    }
}
