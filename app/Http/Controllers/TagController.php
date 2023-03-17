<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Traits\ResponceMessage;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $tags = Tag::get();
        if (count($tags) > 0) {
            return $this->Success('Tags Fetched Successfully', $tags);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateTag = Validator::make($request->all(), [
            'tag_name' => 'required|string|min:5|max:30|unique:tags,tag_name',
        ]);

        if ($validateTag->fails()) {
            return $this->ErrorResponse($validateTag);
        }

        $tag = Tag::create($request->only(
            [
                'tag_name'
            ]
        ));

        return $this->Success('Tag Created Successfully', $tag);
    }

    public function get($id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            return $this->Success('Tag Fetched Successfully', $tag);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateTag = Validator::make($request->all(), [
            'tag_name' => 'required|string|min:5|max:30|unique:tags,tag_name',
        ]);

        if ($validateTag->fails()) {
            return $this->ErrorResponse($validateTag);
        }

        $tag = Tag::find($id);

        if ($tag) {
            $tag->update($request->only(
                [
                    'tag_name'
                ]
            ));

            return $this->Success('Tag Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->delete();
            return $this->Success('Tag Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
