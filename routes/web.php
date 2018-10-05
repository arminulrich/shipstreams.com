<?php
Route::get('/', 'StreamersIndex');
Route::get('/badge', 'BadgeController@show');
Route::get('/resources', 'KitController@show');

Route::group(['middleware' => 'web'], function () {
    // - Submit form
    Route::get('/submit', 'SubmitController@show')->name('submit');
    Route::post('/submit', 'SubmitController@store');
    Route::get('/badge/generate', 'BadgeController@generate')->name('badgeGenerator');
});
Route::get('/{slug}', 'StreamersShow');
