<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapeController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/scrape', [ScrapeController::class, 'run'])->name('scrape');