<?php

use App\Http\Controllers\PlayController;

Route::get('plays', [PlayController::class, 'index'])->name('plays');
Route::post('play', [PlayController::class, 'store'])->name('plays.store');
