<?php
//user-web routes
Route::get("/", [\App\Http\Controllers\UserWebController::class, "userIndex"])->name('user_web_step1');
Route::post("/save-address", [\App\Http\Controllers\UserWebController::class, "saveAddress"])->name('instant.offer.address');
Route::post("/get-offer", [\App\Http\Controllers\UserWebController::class, "getOffer"])->name('instant.offer.getOffer');
Route::get('/step2/{id}', [\App\Http\Controllers\UserWebController::class, "step2"])->name('user_web_step2');

Route::get('/step3/{id}',  [\App\Http\Controllers\UserWebController::class, "step3"])->name('user_web_step3');

Route::get('/deny/{id}', [\App\Http\Controllers\UserWebController::class, "denyOffer"])->name('user_web_deny');
Route::get('/accept/{id}', [\App\Http\Controllers\UserWebController::class, "acceptOffer"])->name('user_web_accept');

Route::view('/failed', 'user_web.failed')->name('user_web_failed');
