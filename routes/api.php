<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'AuthController@authenticate')->name('openlibrary.auth.login');
        Route::group(['middleware' => ['auth.jwt:api']], function () {
            Route::post('/logout', 'AuthController@logout')->name('openlibrary.auth.logout');
            Route::post('/refresh', 'AuthController@refresh')->name('openlibrary.auth.refresh');
            Route::get('/verify', 'AuthController@verify')->name('openlibrary.auth.verify');
        });
    });

    Route::group(['middleware' => ['auth.jwt:api']], function () {
        Route::apiResource('users', 'UserController')->names([
            'index' => 'openlibrary.users.index',
            'store' => 'openlibrary.users.store',
            'show' => 'openlibrary.users.show',
            'update' => 'openlibrary.users.update',
            'destroy' => 'openlibrary.users.destroy'
        ]);

        Route::apiResource('profiles', 'UserProfileController')->names([
            'index' => 'openlibrary.profiles.index',
            'store' => 'openlibrary.profiles.store',
            'show' => 'openlibrary.profiles.show',
            'update' => 'openlibrary.profiles.update',
            'destroy' => 'openlibrary.profiles.destroy'
        ]);

        Route::apiResource('books', 'BookController')->names([
            'index' => 'openlibrary.books.index',
            'store' => 'openlibrary.books.store',
            'show' => 'openlibrary.books.show',
            'update' => 'openlibrary.books.update',
            'destroy' => 'openlibrary.books.destroy'
        ]);

        Route::apiResource('rents', 'BookRentalController')
            ->except(['destroy'])
            ->names([
                'index' => 'openlibrary.rents.index',
                'store' => 'openlibrary.rents.store',
                'show' => 'openlibrary.rents.show',
                'update' => 'openlibrary.rents.update',
                'destroy' => 'openlibrary.rents.destroy'
            ]);
    });
});
