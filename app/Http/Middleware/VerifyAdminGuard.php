<?php

namespace App\Http\Middleware;

use App\Models\admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyAdminGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::user() instanceof admin){
            return response()->json([
                'status'=> false,
                'messgem'=>'Não e uma instancia de adm'
            ]);
        }
        return $next($request);
    }
}
