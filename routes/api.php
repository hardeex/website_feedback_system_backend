<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::post('/projects/{project}/feedback', [FeedbackController::class, 'store']);
Route::put('/feedback/{feedback}', [FeedbackController::class, 'updateDeveloperResponse']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::get('/projects/{project}/feedback', [FeedbackController::class, 'index']);
Route::post('/add/project', [ProjectController::class, 'store']);