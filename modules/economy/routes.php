<?php
Route::post("transactions", "\Modules\Economy\Actions\MakeTransaction")->name('transaction.make');
Route::delete("transactions", "\Modules\Economy\Actions\CancelTransaction")->name('transaction.cancel');
Route::apiResource("fiches.economy-lines", "EconomyLineController");