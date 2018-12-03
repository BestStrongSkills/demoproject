<?php

// =================W1 page 1,2=================================================================

Route::get('/', 'HomeController@index')->name('home');
Route::get('/starIndivisual/{code}', 'HomeController@starIndivisual')->name('starIndivisual');
Route::get('/morePostHome', 'HomeController@mediaPaginator')->name('mediaPaginator');

// ================w2 page 3,top 1 page ========================================================

