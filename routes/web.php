<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\PetsController;
use Illuminate\Http\Request;

Route::get('/', [MainController::class, 'index'])->name('main');

Route::get('/list', [PetsController::class, 'index'])->name('list');

Route::get('/list-by-status/{status}', [PetsController::class, 'list_by_status'])->name('list-by-status');

Route::get('/add', [PetsController::class, 'add'])->name('add');

Route::get('/edit/{id}', [PetsController::class, 'edit'])->name('edit');

Route::post('/api/pet/add', [PetsController::class, 'pet_add_api'])->name('api-add-pet');

Route::post('/api/pet/edit', [PetsController::class, 'pet_edit_api'])->name('api-edit-pet');

Route::post('/api/pet/delete', [PetsController::class, 'pet_delete_api'])->name('api-delete-pet');
