<?php


use Illuminate\Support\Facades\Route;
use app\Http\Controllers\SlotsController;

Route::get('/', function () {
    return view('welcome');
});
//Route::get('/api/slots', [SlotsController:class,'getAvailableSlots']);
