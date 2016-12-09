<?php

namespace App\Providers;

use app\Conversion;
use App\Invoice;
use app\MasterList;
use App\Policies\ConversionPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\MasterListPolicy;
use App\Policies\RecipePolicy;
use app\Recipe;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        MasterList::class => MasterListPolicy::class,
        Invoice::class => InvoicePolicy::class,
        Recipe::class => RecipePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
