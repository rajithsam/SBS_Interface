<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\View as View;
use App\Permission as Permission;
use App\User as User;


class ACL
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->user()->isActive)
             return redirect('Forbidden');

        if($request->user()->isSuperUser)
            return $next($request); 

        $permissions = $request->user()->permissions()->get();
        foreach ($permissions as $permission) 
        {
            $views = $permission->views()->get();
            foreach ($views as $view) 
            {
                if( $request->is(preg_replace("[{.*}]", "*" , $view->path)))
                {
                    return $next($request); 
                }
            }
        }

        return redirect('Forbidden');

    }
}
