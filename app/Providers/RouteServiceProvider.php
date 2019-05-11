<?php

namespace App\Providers;

use App\Models\Chatter\Forum;
use App\Models\Chatter\Thread;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('forum_id', function($id, $route) {
            if (!$route->hasParameter('forum_slug')) {
                return abort(404);
            }

            $forum = Forum::find($id);

            if (!$forum) {
                return abort(404);
            }

            if ($forum->slug != $route->parameter('forum_slug')) {
                return redirect()->route('chatter.forum', [$forum->slug, $id], 301)->send();
            }

            return $forum;
        });

        Route::bind('thread_id', function($id, $route) {
            if (!$route->hasParameter('thread_slug')) {
                return abort(404);
            }

            $thread = Thread::find($id);

            if (!$thread) {
                return abort(404);
            }

            if ($thread->slug != $route->parameter('thread_slug')) {
                return redirect()->route('chatter.thread', [$thread->slug, $id], 301)->send();
            }

            return $thread;
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
