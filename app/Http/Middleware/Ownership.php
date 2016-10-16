<?php

namespace App\Http\Middleware;

use App\MasterList;
use App\Recipe;
use App\RecipeElement;
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
        $routeName = $request->route()->parameterNames();
        
        switch($routeName[0]){
            case 'masterlist':
                $masterlist = MasterList::find($id['masterlist']);

                if ($masterlist->owner != Auth::user()->id){
                    return redirect()->route('masterlist.index');
                }
                return $next($request);
            case 'recipe':
                $recipes = Recipe::find($id['recipe']);

                if ($recipes->owner != Auth::user()->id){
                    return redirect()->route('recipes.index');
                }

                if (isset($routeName[1]) && $routeName[1] == 'element'){
                    $elements = RecipeElement::find($id['element']);
                    if ($elements->owner != Auth::user()->id){
                        return redirect()->route('recipes.index');
                    }

                }
                return $next($request);
            default:
                return redirect('/');
        }        
    }
}
