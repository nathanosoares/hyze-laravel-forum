<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/', 'HomeController@index')->name('home');

// Route::get('auth/login', function () {
//     $url = \Spatie\Url\Url::fromString(url()->previous());

//     if ($url->getPath() === '/auth/login') {
//         $url = \Spatie\Url\Url::fromString(route('home'));
//     }

//     $url = $url->withQueryParameter('modal', 'signin');

//     return redirect((string) $url);
// })->name('login');

Route::prefix('forums')->name('forums.')->namespace('Forums')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/{forum_slug}.{forum_id}/create-thread', 'ThreadController@create')
        //        ->middleware('auth:web')
        ->name('forum.create_thread');

    Route::get('/{forum_slug}.{forum_id}', 'ForumController@index')->name('forum');
    Route::get('/category/{category_slug}', 'CategoryController@index')->name('category');
    Route::get('/thread/{thread_slug}.{thread_id}', 'ThreadController@show')->name('thread');
});

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('details', 'Profile\DetailsController@index')->name('details');

        // Security
        Route::get('security', 'Profile\SecurityController@index')->name('security');
        Route::put('security/update/email', 'Profile\SecurityController@updateEmail')->name('security.update.email');
        Route::put('security/update/password', 'Profile\SecurityController@updatePassword')->name('security.update.password');
    });
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware('super.admin')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/tree', 'TreeController@index')->name('tree');
    Route::post('/tree/sort', 'TreeController@sort')->name('tree.sort');

    Route::resource('categories', 'CategoryController')->only([
        'create', 'store', 'edit', 'update'
    ]);

    Route::resource('forums', 'ForumController')->only([
        'create', 'store', 'edit', 'update'
    ]);
});

Route::get('/home', 'HomeController@index')->name('home');
