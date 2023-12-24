<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$roles) {
            abort('400', 'Your role not associated for this route');
        }
        if(!$request->user()){
            abort('401', 'No user logged in yet! to use this module');
        }
        $userRoles = new \ReflectionClass(UserRole::class);
        $userRoleFound = false;
        foreach ($roles as $role) {
            $userRole = $userRoles->getConstant($role);
            if (is_array($userRole) && in_array($request->user()->user_role, $userRole)) {
                $userRoleFound = true;
                break;
            } else if ($userRole == $request->user()->user_role) {
                $userRoleFound = true;
                break;
            }
        }
        if (!$userRoleFound) {
            abort('401', 'You are not authorized to use this module');
        }
        return $next($request);
    }
}
