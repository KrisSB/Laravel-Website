<?php

namespace App\Providers;

use App\WikiPost;
use App\Game;
use App\Wiki;

use App\Policies\PostPolicy;
use App\Policies\GamePolicy;
use App\Policies\WikiPolicy;

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
        WikiPost::class => PostPolicy::class,
        Game::class => GamePolicy::class,
        Wiki::class => WikiPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::resource('posts', PostPolicy::class);
        Gate::define('posts.pushUpdate','App\Policies\PostPolicy@pushUpdate');
        
        Gate::resource('games', GamePolicy::class);

        Gate::resource('wikis', WikiPolicy::class);
        Gate::define('wikis.pushUpdate','App\Policies\WikiPolicy@pushUpdate');
    }
}
