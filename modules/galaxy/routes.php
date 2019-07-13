<?php
Route::apiResource("secteurs", "SecteursController");
Route::apiResource("secteurs.planets", "PlanetsController");
Route::get("planets/{planet}/managers/{personnage}", "PlanetsController@setAsManager")
    ->name("planet.setManager");
Route::delete("planets/{planet}/managers/{personnage}", "PlanetsController@removeAsManager")
    ->name("planet.removeManager");