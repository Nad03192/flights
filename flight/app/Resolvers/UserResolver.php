<?php
namespace App\Resolvers;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\UserResolver as ContractsUserResolver;
class UserResolver implements ContractsUserResolver
{
     public static function resolve()
    {
        $guards = config('audit.user.guards');
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
    }
}