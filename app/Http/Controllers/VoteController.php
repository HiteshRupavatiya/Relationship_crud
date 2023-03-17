<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vote;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $votes = User::with('votes')->get();
        if ($votes) {
            return $this->Success('Votes Fetched Successfully', $votes);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateVote = Validator::make($request->all(), [
            'name'    => 'required|alpha|max:20',
            'user_id' => 'required|numeric|exists:users,id'
        ]);

        if ($validateVote->fails()) {
            return $this->ErrorResponse($validateVote);
        }

        $vote = Vote::create($request->only(
            [
                'name',
                'user_id'
            ]
        ));

        return $this->Success('Votes Created Successfully', $vote);
    }

    public function get($id)
    {
        $vote = Vote::find($id);
        if ($vote) {
            return $this->Success('Vote Fetched Successfully', $vote);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateVote = Validator::make($request->all(), [
            'name'    => 'required|alpha|max:20',
        ]);

        if ($validateVote->fails()) {
            return $this->ErrorResponse($validateVote);
        }

        $vote = Vote::find($id);

        if ($vote) {
            $vote->update($request->only(
                [
                    'name',
                ]
            ));

            return $this->Success('Votes Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $vote = Vote::find($id);
        if ($vote) {
            $vote->delete();
            return $this->Success('Vote Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
