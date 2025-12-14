<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            // หากผู้ใช้ไม่ได้ล็อกอิน หรือ บทบาทไม่ตรงกับที่กำหนด ให้ทำ Redirect หรือ Abort
            abort(403, 'Unauthorized action.'); // หรือ return redirect('/');
        }
        
        return $next($request);
    }
}
