<?php

namespace App\Http\Controllers\Loan;

use Illuminate\Http\Request;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function applyLoan(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'monthly_income' => 'required|integer|min:1',
        ]);

        if ($request->amount > $request->monthly_income / 3) {
            return response(['message' => 'Loan amount cannot exceed 1/3 of monthly income'], 400);
        }

        $loan = Loan::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'monthly_income' => $request->monthly_income,
            'status' => 'pending',
        ]);

        return response(['message' => 'Loan application submitted', 'loan' => $loan], 201);
    }

    public function viewLoans()
    {
        $loans = Loan::with('user')->get();
        return response(['loans' => $loans]);
    }

    public function approveLoan($id)
    {
        $loan = Loan::find($id);
        if (!$loan) return response(['message' => 'Loan not found'], 404);

        $loan->status = 'approved';
        $loan->save();

        return response(['message' => 'Loan approved']);
    }

    public function declineLoan($id)
    {
        $loan = Loan::find($id);
        if (!$loan) return response(['message' => 'Loan not found'], 404);

        $loan->status = 'declined';
        $loan->save();

        return response(['message' => 'Loan declined']);
    }
}


