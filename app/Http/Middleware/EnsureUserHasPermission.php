<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    use Helpers;
    public function handle(
        Request $request,
        Closure $next,
        string $permissions
    ): Response {
        $requiredPermissions = explode('|', $permissions);
        if (!$requiredPermissions) {
            $requiredPermissions = [];
        }

        $user = User::with('roles.permissions')->find(Auth::id());
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $user = $this->extractPermissionsFromUser($user);

        $userPermissions = $user->permissions
            ->map(fn($permission) => $permission->name)
            ->values()
            ->all();

        if (!count(array_intersect($userPermissions, $requiredPermissions))) {
            return response()->json(
                [
                    'message' => 'Permission not granted.',
                    'permissions' => $requiredPermissions,
                ],
                401
            );
        }

        $request->merge(['user' => $user]);

        return $next($request);
    }
}
