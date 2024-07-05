<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        return Loan::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'issued_date' => 'required|date',
            'due_date' => 'required|date',
            'returned_date' => 'nullable|date',
            'fine_amount' => 'nullable|numeric',
        ]);

        $loan = Loan::create($request->all());

        return response()->json($loan, 201);
    }

    public function show(Loan $loan)
    {
        return response()->json($loan);
    }

    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'book_id' => 'sometimes|required|exists:books,id',
            'member_id' => 'sometimes|required|exists:members,id',
            'issued_date' => 'sometimes|required|date',
            'due_date' => 'sometimes|required|date',
            'returned_date' => 'nullable|date',
            'fine_amount' => 'nullable|numeric',
        ]);

        $loan->update($request->all());

        return response()->json($loan, 200);
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();

        return response()->json(null, 204);
    }
}
