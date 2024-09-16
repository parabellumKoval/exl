<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

use App\Models\Landing;

class LandingIsActive
{
  public function handle(Request $request, Closure $next) {
    $landing = Landing::where('key', config('app.name'))->first();

    if($landing->is_active !== null && $landing->is_active === 0 && !$request->routeIs('home')) {
      return redirect('/', 302);
    }else {
      return $next($request);
    }
  }
}
