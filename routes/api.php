<?php

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function(){
    // Categories
    Route::group(['prefix' => 'categories'], function(){
        // Get the categories
        Route::get('list', 'CategoriesController@list');
        // Get the category
        Route::get('{category_id}', 'CategoriesController@get')->name('api.categories.get');
        // Remove a selected category
        Route::delete('{category_id}', 'CategoriesController@delete')->name('api.categories.delete');
        // Create a new category
        Route::post('create', 'CategoriesController@create');
        // Update category
        Route::post('update/{category_id}', 'CategoriesController@update');

    });

    // Photos
    Route::group(['prefix' => 'photos'], function() {
        // Get the latest photos
        Route::get('latest', 'PhotosController@latest');
        // Upload photo
        Route::post('upload', 'PhotosController@upload');
        // Get photos from selected category
        Route::get('list/{category_id}', 'PhotosController@list');
        // Remove photo
        Route::delete('{photo_id}', 'PhotosController@delete');
        // Set as cover
        Route::get('cover/{photo_id}', 'PhotosController@cover');
    });
});

Route::get('categories', 'Api\ApiController@categories');
Route::get('category/{category_id}', 'Api\ApiController@category');

Route::get('photos/{category_id}', 'Api\ApiController@photos');
Route::get('photo/{photo_id}', 'Api\ApiController@photo');

Route::get('next/{photo_id}', 'Api\ApiController@next');
Route::get('prev/{photo_id}', 'Api\ApiController@prev');
Route::get('random', 'Api\ApiController@random');

