<?php
Route::post("api/transactions", "\Modules\Economy\Actions\MakeTransaction")->name('transaction.make');
Route::delete("api/transactions", "\Modules\Economy\Actions\CancelTransaction")->name('transaction.cancel');
