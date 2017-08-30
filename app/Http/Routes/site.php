<?php

// Route::post('test/animeSteal', 'TestController@animeSteal');
Route::resource('test', 'TestController');
// Route::get('mixdb/{typeId}', 'TestController@mixdb');

Route::post('epchap', 'SiteController@epchap');
// Route::post('bookpaging', 'SiteController@bookpaging');
Route::post('errorreporting', 'SiteController@errorreporting');
Route::post('rating', 'SiteController@rating');
Route::post('contact', 'SiteController@contact');
Route::get('sitemap.xml', 'SiteController@sitemap');
Route::get('livesearch', 'SiteController@livesearch');
Route::get('tim-kiem', ['uses' => 'SiteController@search', 'as' => 'site.search']);
Route::get('/', 'SiteController@index');
Route::get('hang-phim', 'SiteController@author');
Route::get('danh-sach-movie', 'SiteController@listmovie');
Route::get('danh-sach-tv-series', 'SiteController@listtv');
Route::get('tag/{slug}', 'SiteController@tag');
Route::get('the-loai/{slug}', 'SiteController@type');
Route::get('seri/{slug}', 'SiteController@seri');
Route::get('xem-phim-hoat-hinh-{slug}', 'SiteController@nation');
Route::get('danh-sach-phim-{slug}', 'SiteController@kind');
Route::get('xem-anime-nam-{slug}', 'SiteController@year');
Route::get('xem-anime-truoc-nam-{slug}', 'SiteController@yearbefore');
Route::get('danh-sach-anime-mua-{slug1}-nam-{slug2}', 'SiteController@seasonYear');
Route::get('{slug1}/{slug2}', 'SiteController@page2');
Route::get('{slug}', 'SiteController@page');
