<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/',[App\Http\Controllers\HomeController::class, 'index'])->name('Lista');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('Lista');
Route::post('/agregarEmpleado', [App\Http\Controllers\HomeController::class, 'addEmployer'])->name('Lista');

Route::post('/importarCSV', [App\Http\Controllers\HomeController::class, 'import_data_file'])->name('Lista');
