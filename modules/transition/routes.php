<?php
Route::post("personnages/{personnage}/claim", "TransitionPersonnageController@claimPersonnage")->name('personnages.claim')->middleware('auth:api');
Route::get("transition/users", "TransitionPersonnageController@users");
