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

// Auth::routes();
// Because we don't use a full auth system, the following routes is enaught
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

// Not standard authentificate method
Route::post('login', 'Auth\LoginController@authenticate');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', function () {
    if (Route::has('login')) {
        return redirect()->to(route('login'));
    } else {
        return view('welcome');
    }
});

// Change locale
Route::post('/lang', function () {
    session()->put('lang', Request::input('lang'));
    return redirect()->back();
})->name('setLang')->middleware('lang');

Route::get('/{short}', 'ShortsRedirectController@index')
    ->where(['short'=>'[a-zA-Z0-9]{10}'])
    ->name('shorts.redirect');

Route::group(['prefix'=> '/admin', 'middleware' => 'auth'], function() {

    // Shorts help
    Route::get('/help', function() {
        $view = 'backend.help.index_' . app()->getLocale();
        return view($view);
    })->name('admin.shorts.help');

    // Shorts CRUD
    Route::get('/', 'Backend\ShortsController@index')
        ->name('admin.shorts.index');

    Route::get('/shorts/add', 'Backend\ShortsController@add')
        ->name('admin.shorts.add');

    Route::get('/shorts/{id}/edit', 'Backend\ShortsController@edit')
        ->name('admin.shorts.edit')
        ->where(['id' => '[0-9]+']);

    Route::get('/shorts/{id}/view', 'Backend\ShortsController@show')
        ->name('admin.shorts.view')
        ->where(['id' => '[0-9]+']);

    Route::delete('/shorts/delete', 'Backend\ShortsController@delete')
        ->name('admin.shorts.delete');

    Route::put('/shorts/{id}/save', 'Backend\ShortsController@save')
        ->name('admin.shorts.edit.save')
        ->where(['id' => '[0-9]+']);

    Route::post('/shorts/save', 'Backend\ShortsController@save')
        ->name('admin.shorts.add.save');

    // Download QR code
    Route::post('/shorts/{id}/download', 'Backend\ShortsController@download')
        ->name('admin.shorts.download')
        ->where(['id' => '[0-9]+']);

    // Import csv
    Route::post('/shorts/upload', 'Backend\ImportController@upload')->name('admin.shorts.upload');

    // Users
    Route::group(['middleware' => 'can:all, App\User'], function() {
        Route::get('/users', 'Backend\UserController@index')
            ->name('admin.users.index');
        Route::get('/users/add', 'Backend\UserController@add')
            ->name('admin.users.add');
        Route::get('/users/{id}/edit', 'Backend\UserController@edit')
            ->name('admin.users.edit')
            ->where(['id' => '[0-9]+']);
        Route::delete('/users/delete', 'Backend\UserController@delete')
            ->name('admin.users.delete');
        Route::post('/users/save', 'Backend\UserController@save')
            ->name('admin.users.add.save');
        Route::put('/users/{id}/save', 'Backend\UserController@save')
            ->name('admin.users.edit.save')
            ->where(['id' => '[0-9]+']);
    });
});

