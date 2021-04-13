<?php

use App\Http\Controllers\GameController;

Route::get('games', [GameController::class, 'index'])->name('games');
Route::post('games', [GameController::class, 'store'])->name('games.store');
