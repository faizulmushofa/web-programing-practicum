<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::apiResource('books', BookController::class);
Route::apiResource('members', MemberController::class);
Route::post('members/{member}/borrow', [MemberController::class, 'borrowBook']);
Route::post('members/{member}/return/{book}', [MemberController::class, 'returnBook']);
