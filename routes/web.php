<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
Route::get('/', function () {
    return view('welcome');
});

Route::view('/index', 'singlepage');

Route::post('savedata', [AjaxController::class, 'savedata'])
    ->name('ajax');

Route::get('getdata', [AjaxController::class, 'getdata']);

Route::post('editdata', [AjaxController::class, 'editdata']);

Route::post('deletedata', [AjaxController::class, 'deletedata']);
