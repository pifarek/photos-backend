<?php

Auth::routes(['register' => false]);

Route::get('logout', 'IndexController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'IndexController@index')->name('home');



    // Photos
    Route::resource('photos', 'PhotosController')->except(['show', 'destroy']);

    Route::group(['prefix' => 'photos'], function() {
        // Upload temporary image
        Route::post('json/temporary', 'PhotosController@temporary')->name('photos.temporary');
        //Route::get('json/remove/{category_id}', 'CategoriesController@remove');

        // Remove photo
        Route::get('json/remove/{photo_id}', 'PhotosController@remove')->name('photos.remove');
    });

    // Categories
    Route::resource('categories', 'CategoriesController');

    Route::group(['prefix' => 'categories'], function() {
        Route::get('json/remove/{category_id}', 'CategoriesController@remove');
    });
});
