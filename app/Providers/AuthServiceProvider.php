<?php

namespace App\Providers;

use App\Extensions\HyzeUserProvider;
use App\Models\Forums\Category;
use App\Models\Forums\Forum;
use App\Models\Forums\Post;
use App\Models\Forums\Thread;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\ForumPolicy;
use App\Policies\PostPolicy;
use App\Policies\ThreadPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Thread::class => ThreadPolicy::class,
        Post::class => PostPolicy::class,
        Forum::class => ForumPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Passport::routes();

        Gate::before(function (User $user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        Auth::provider('hyze', function ($app, array $config) {
            return new HyzeUserProvider(
                $app->make('db')->connection('hyze'),
                $app->make('hash'),
                'users'
            );
        });
    }
}
