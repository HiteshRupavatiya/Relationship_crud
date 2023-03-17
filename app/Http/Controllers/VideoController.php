<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Traits\ResponceMessage;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $videos = Video::with('tags')->get();
        if (count($videos) > 0) {
            return $this->Success('Videos Fetched Successfully', $videos);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateVideo = Validator::make($request->all(), [
            'video_name'  => 'required|string|min:5|max:30|unique:videos,video_name',
            'description' => 'required|string|max:200',
            'tag_id'      => 'required|array|exists:tags,id'
        ]);

        if ($validateVideo->fails()) {
            return $this->ErrorResponse($validateVideo);
        }

        $video = Video::create($request->only(
            [
                'video_name',
                'description'
            ]
        ));

        $video->tags()->attach($request->tag_id);

        return $this->Success('Video Created Successfully', $video);
    }

    public function get($id)
    {
        $video = Video::find($id);
        if ($video) {
            return $this->Success('Video Fetched Successfully', $video);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateVideo = Validator::make($request->all(), [
            'video_name'  => 'required|string|min:5|max:30|unique:videos,video_name',
            'description' => 'required|string|max:200',
            'tag_id'      => 'required|array|exists:tags,id'
        ]);

        if ($validateVideo->fails()) {
            return $this->ErrorResponse($validateVideo);
        }

        $video = Video::find($id);

        if ($video) {
            $video->update($request->only(
                [
                    'video_name',
                    'description'
                ]
            ));

            $video->tags()->sync($request->tag_id);

            return $this->Success('Video Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $video = Video::find($id);

        if ($video) {
            $video->delete();
            $video->tags()->detach();

            return $this->Success('Video Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
