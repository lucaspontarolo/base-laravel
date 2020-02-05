<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRolesEnum;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        $user = $request->user();
        if (!$user->hasRole(UserRolesEnum::CLIENT)) {
            return response()->json([
                "message" => Lang::get('auth.invalid_role'),
            ], HttpResponse::HTTP_UNAUTHORIZED);
        }

        $request->request->add([
            'username' => request($this->username()),
            'grant_type' => 'password',
        ]);

        $tokenRequest = Request::create('/oauth/token', 'post');
        return Route::dispatch($tokenRequest);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'client_id' => "required|integer",
            'client_secret' => "required|string",
        ]);
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        $user = $this->guard()->user();
        $authorizationResponse = $this->authenticated($request, $user);
        if ($authorizationResponse) {
            return $authorizationResponse;
        }

        return response()->json([
            "message" => Lang::get('auth.failed'),
        ], HttpResponse::HTTP_UNAUTHORIZED);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            "message" => Lang::get('auth.failed'),
        ], HttpResponse::HTTP_UNAUTHORIZED);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return response()->json([
            "message" => [Lang::get('auth.throttle', ['seconds' => $seconds])],
        ], HttpResponse::HTTP_TOO_MANY_REQUESTS);
    }
}
