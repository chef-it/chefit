<?php

namespace App\Http\Middleware;

use App\MasterList;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Ownership
{
    /**
     * Redirect to index if not owner of record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * For some reason when it is a resource route, the id is assigned to an array key named
         * the same as the route. $id['masterlist'] is the id parameter passed in the url.
         */
        $id = $request->route()->parameters();
        $masterlist = MasterList::find($id['masterlist']);

        if ($masterlist->owner != Auth::user()->id){
            return redirect()->route('masterlist.index');
        }
        return $next($request);
    }
}
