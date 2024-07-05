<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservation::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'reserved_date' => 'required|date',
            'notification_sent' => 'required|boolean',
        ]);

        $reservation = Reservation::create([
            'book_id' => $request->book_id,
            'member_id' => $request->member_id,
            'reserved_date' => $request->reserved_date,
            'notification_sent' => $request->notification_sent,
        ]);

        return response()->json($reservation, 201);
    }

    public function show(Reservation $reservation)
    {
        return response()->json($reservation);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'book_id' => 'sometimes|required|exists:books,id',
            'member_id' => 'sometimes|required|exists:members,id',
            'reserved_date' => 'sometimes|required|date',
            'notification_sent' => 'sometimes|required|boolean',
        ]);

        $reservation->update($request->all());

        return response()->json($reservation, 200);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json(null, 204);
    }
}
