<?php

use Glide\Controllers\TestInfrastructureController;

\Route::get('/test-infrastructure', TestInfrastructureController::class)->name('qa.test-infrastructure');
