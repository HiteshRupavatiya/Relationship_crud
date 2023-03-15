<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{
    public function list()
    {
        $votes = Vote::with('user')->get();
        return response()->json([
            'status'  => true,
            'message' => 'Votes Fetched Successfully',
            'Votes'   => $votes
        ]);
    }

    public function create(Request $request)
    {
        $validateVote = Validator::make($request->all(), [
            'name'    => 'required|alpha|max:20',
            'user_id' => 'required|numeric|exists:users,id'
        ]);

        if ($validateVote->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateVote->errors()
            ]);
        }

        $vote = Vote::create($request->only(
            [
                'name',
                'user_id'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Votes Created Successfully',
            'Vote'   => $vote
        ]);
    }

    public function get($id)
    {
        $vote = Vote::findOrFail($id);
        if ($vote) {
            return response()->json([
                'status'  => true,
                'message' => 'Vote Fetched Successfully',
                'Vote'    => $vote
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateVote = Validator::make($request->all(), [
            'name'    => 'required|alpha|max:20',
        ]);

        if ($validateVote->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateVote->errors()
            ]);
        }

        $vote = Vote::findOrFail($id);

        $vote->update($request->only(
            [
                'name',
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Votes Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $vote = Vote::findOrFail($id);
        if ($vote) {
            $vote->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Votes Deleted Successfully'
            ]);
        }
    }
}
