<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Loan\LoanController;



// User Registration API
// POST /api/register
Route::post('/register', [AuthController::class, 'register']);

// User Login API
// POST /api/login
Route::post('/login', [AuthController::class, 'login']);

// Protected APIs - Requires Authentication
Route::middleware('auth:sanctum')->group(function () {
    // Loan Application API
    // POST /api/apply-loan
    Route::post('/apply-loan', [LoanController::class, 'applyLoan']);

    // Admin View All Loans API
    // GET /api/loans
    Route::get('/loans', [LoanController::class, 'viewLoans']);

    // Admin Approve Loan API
    // POST /api/approve-loan/{id}
    Route::post('/approve-loan/{id}', [Loan/LoanController::class, 'approveLoan']);

    // Admin Decline Loan API
    // POST /api/decline-loan/{id}
    Route::post('/decline-loan/{id}', [LoanController::class, 'declineLoan']);
});

