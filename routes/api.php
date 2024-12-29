<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\APIController;

Route::post('/jobs', [APIController::class, 'index']);