<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return Member::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // Assuming users table exists for user_id
            'membership_date' => 'required|date',
            'membership_status' => 'required|string|max:255',
        ]);

        $member = Member::create([
            'user_id' => $request->user_id,
            'membership_date' => $request->membership_date,
            'membership_status' => $request->membership_status,
        ]);

        return response()->json($member, 201);
    }

    public function show(Member $member)
    {
        return response()->json($member);
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'membership_date' => 'sometimes|required|date',
            'membership_status' => 'required|string|max:255',
        ]);

        $member->update($request->all());

        return response()->json($member, 200);
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json(['message' => 'membership deleted successfully'], 201);
    }
}
