<?php
Route::apiResource("fiches.economy-lines", "EconomyLineController")->middleware('auth:api');
Route::get("fiches/{fich}/economy-lines/{number}/validate", "EconomyLineController@validation")->middleware('auth:api');
Route::get("fiches/{personnage}", "FicheController@show")->name('fiche.show');
Route::post("accounts/complex", "AccountController@complexTransaction")->name('account.complexTransaction')->middleware('auth:api');
Route::get("accounts/{account}", "AccountController@show")->name('account.show');
Route::post("accounts/find", "AccountController@find")->name('account.find');
Route::post("accounts/{account}", "AccountController@fromAccountToAnother")->name('account.fromAccountToAnother')->middleware('auth:api');
Route::get("accounts/{account}/freeze", "AccountController@freeze")->name('account.freeze')->middleware('auth:api');
