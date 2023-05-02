<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckLoginAdmin
{
    /**
     *
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $roles = Auth::user()->getRoleNames();
            foreach($roles as $role){
                if($role == "Manager" || $role == "Admin"){
                    return $next($request)->header('Access-Control-Allow-Origin', '*');
                }
            }
        }
        // if (Auth::check()) {
        //     foreach($roles as $role){
        //         if($role == "User"){
        //             return redirect()->route('home')->with([
        //                 "mess" => "Đăng nhập thành công",
        //             ]);
        //         }
        //     }
        // }
        return redirect()->route('login')->with([
            "mess" => "Bạn cần đăng nhập là admin để tiếp tục",
        ]);
    }
}
