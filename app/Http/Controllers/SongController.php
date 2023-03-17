<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use App\Traits\ResponceMessage;
use Illuminate\Support\Facades\Validator;

class SongController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $songs = Song::with('tags')->get();
        if (count($songs) > 0) {
            return $this->Success('Songs Fetched Successfully', $songs);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateVideo = Validator::make($request->all(), [
            'song_name'   => 'required|string|min:5|max:30|unique:songs,song_name',
            'description' => 'required|string|max:200',
            'tag_id'      => 'required|array|exists:tags,id'
        ]);

        if ($validateVideo->fails()) {
            return $this->ErrorResponse($validateVideo);
        }

        $song = Song::create($request->only(
            [
                'song_name',
                'description'
            ]
        ));

        $song->tags()->attach($request->tag_id);

        return $this->Success('Song Created Successfully', $song);
    }

    public function get($id)
    {
        $song = Song::find($id);
        if ($song) {
            return $this->Success('Song Fetched Successfully', $song);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateVideo = Validator::make($request->all(), [
            'song_name'   => 'required|string|min:5|max:30|unique:songs,song_name',
            'description' => 'required|string|max:200',
            'tag_id'      => 'required|array|exists:tags,id'
        ]);

        if ($validateVideo->fails()) {
            return $this->ErrorResponse($validateVideo);
        }

        $song = Song::find($id);

        if ($song) {
            $song->update($request->only(
                [
                    'song_name',
                    'description'
                ]
            ));

            $song->tags()->sync($request->tag_id);

            return $this->Success('Song Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $song = Song::find($id);

        if ($song) {
            $song->delete();
            $song->tags()->detach();

            return $this->Success('Song Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
