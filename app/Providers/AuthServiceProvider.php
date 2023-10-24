<?php

namespace App\Providers;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('update-post', function($user){

            $permission = $user->type === 'admin';
            return $permission
                ? Response::allow()
                : Response::deny('Você deve ser admin para realizar esta ação.');
        });

        Gate::define('delete-post', function($user, $post){
            return $post->owner == $user->id
                ? Response::allow()
                : Response::deny('Você não é o autor deste post.');
        });
    }
}
