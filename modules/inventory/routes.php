<?php
Route::apiResource('object-types', "ObjectTypeController");
Route::apiResource('object-types.objects', "ObjectController");
Route::apiResource('object-types.improvements', "ImprovementController");
Route::apiResource('possessions', "PossessionController");