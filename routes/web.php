<?php

use Illuminate\Support\Facades\Route;

Route::get(
    '/{any}',
    fn () => view('app')
)->where('any', '.*');
