<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers
 */
class AuthController extends ApiController
{
    public function login(Request $request)
    {
        //Illuminate\Support\Facades\Validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.exists' => 'Email is not registered',
        ]);

        if ($validator->fails()) {
            return $this->userErrorResponse($validator->getMessageBag()->toArray());
        }

        $user = User::where('email', $request->get('email'))->first();

        if (!Hash::check($request->get('password'), $user->password)) {
            return $this->userErrorResponse(['login' => 'Invalid login (password)']);
        }

        $user->api_token = \Illuminate\Support\Str::random(60);
        $user->save();

        return $this->successResponse(['user' => $user->toArray()]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return $this->successResponse(['data' => 'User logged out.']);
    }
}
