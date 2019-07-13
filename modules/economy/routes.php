<?php
Route::get("api/transactions", "\Modules\Economy\Actions\MakeTransaction")->name('transaction.make');
Route::delete("api/transactions", "\Modules\Economy\Actions\MakeTransaction")->name('transaction.cancel');
