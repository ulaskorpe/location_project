<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;
class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //if($request->session()->get('admin_id') == null){
        if(Session::get('admin_id') == null){
            return redirect('login');
            //   }elseif($request->session()->get('user_id') != null){
            //   echo $request->session()->get('user_id');
            //return redirect('/');
        }
        return $next($request);
    }
}
