<?php
Route::post("personnages/{personnage}/claim", "TransitionPersonnageController@claimPersonnage")->name('personnages.claim')->middleware('jwt.auth');