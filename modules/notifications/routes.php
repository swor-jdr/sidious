<?php
Route::get('notifications/unread', "NotificationController@unread")->name('notifications.unread')->middleware("jwt.auth");
Route::get('notifications/mark', "NotificationController@markNotification")->name('notifications.mark')->middleware("jwt.auth");