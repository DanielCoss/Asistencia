<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('Lista');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('Lista');
Route::post('/agregarEmpleado', [App\Http\Controllers\AddEmployerController::class, 'addEmployer'])->name('Lista');

Route::post('/importarCSV', [App\Http\Controllers\AddFileController::class, 'import_data_file'])->name('Lista');

Route::get('/empleado/{id_employer}', [App\Http\Controllers\EmployerController::class, 'seeEmployer']);
Route::post('/editarAsistencia', [App\Http\Controllers\EmployerController::class, 'editAsistance']);

Route::get('/salones', [App\Http\Controllers\ClassromController::class, 'seeClassroms']);

Route::any('/salon/{id_classrom}', [App\Http\Controllers\ClassromController::class, 'seeClassrom']);

Route::get('/calendario',[App\Http\Controllers\HomeController::class, 'calendar']);

Route::get('/empleado/{id_employer}/calendar', [App\Http\Controllers\EmployerController::class, 'calendarInfo']);
