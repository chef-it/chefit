<?php

namespace App\Policies;

use app\Recipe;
use App\User;
use App\RecipeElement;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipeElementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the recipeElement.
     *
     * @param  \App\User  $user
     * @param  \App\RecipeElement  $recipeElement
     * @return mixed
     */
    public function element(User $user, RecipeElement $element, Recipe $recipe)
    {
        return $user->id === $recipe->user_id && $recipe->id === $element->recipe_id;
    }
}
