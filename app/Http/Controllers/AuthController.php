<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Network;
use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    const UNAUTHORIZED_MSG = "Username or Password is invalid";
    const INACTIVE_NETWORK_MSG = "Network is inactive";

    public function username()
    {
        return "username";
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $credentials["status"] = true;

        $token = Auth::attempt($credentials);
        if (!$token) {
            return $this->errorResponse(AuthController::UNAUTHORIZED_MSG, 400);
        }

        $networkStatus = Network::where("id", Auth::user()->network_id)->pluck("status");
        if (!$networkStatus) {
            return $this->errorResponse(AuthController::INACTIVE_NETWORK_MSG, 400);
        }

        $session = new Session();
        $session->user_id = Auth::id();
        $session->token = $token;
        $session->expire_at = Carbon::now()->addMinutes(env('JWT_TTL', 60));
        $session->ip = $request->ip();
        $session->save();

        return $this->successResponse([
                "token" => $token,
                "user" => Auth::user()
        ]);
    }

    public function logout(): JsonResponse
    {
        Session::where("token", request()->bearerToken())->update(["is_logged_out" => true]);
        Auth::logout();
        return $this->successResponse([], "Logged Out Successfully");
    }

    public function getUserDetails()
    {
        return ["data" => Auth::user()];
    }
}
