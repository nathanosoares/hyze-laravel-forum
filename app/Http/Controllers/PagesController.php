<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function show(Request $request, $page)
    {
        if (view()->exists('pages.guest.' . $page)) {
            $view = 'pages.guest.' . $page;
        } else if (view()->exists('pages.auth.' . $page)) {

            if (!auth()->guard()->check()) {
                throw new AuthenticationException(
                    'Unauthenticated.',
                    [auth()->guard()],
                    route('login')
                );
            }

            $view = 'pages.auth.' . $page;
        } else {
            abort(404);
        }
        
        abort(404);

        $className = 'App\\Extensions\\Pages\\' . ucfirst(strtolower($page)) . 'PageController';

        $data = [];

        if (class_exists($className)) {
            $controller = new $className();

            $data = $controller->getData($request);
        }

        return view($view, $data);
    }
}
