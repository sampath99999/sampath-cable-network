<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserCreateRequest;
use App\Models\Menu;
use App\Models\User;
use App\Models\UserCreationRoles;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function getMenus()
    {
        try {
            $menuItems = Menu::where('role_id', Auth::user()->role_id)
                ->where('status', true)
                ->orderBy('priority')
                ->get();
            return response()->json(["data" => $menuItems]);
        } catch (\Exception $e) {
            report($e);
            return response()->json(["message" => "Something Went Wrong, Error Code: GET_MENUS"], 500);
        }
    }

    public function createUser(UserCreateRequest $request){
        try {
            $userDetails = $request->validated();
            $userDetails["network_id"] = Auth::user()["network_id"];
            $user = User::create($userDetails);
            return $this->successResponse(["user" => $user]);
        } catch(\Exception $e){
            report($e);
            return $this->exceptionResponse($e);
        }
    }

    public function getRoles(){
        return $this->successResponse(["roles" => UserRole::get()]);
    }
}
