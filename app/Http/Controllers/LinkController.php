<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $links = Link::with('link_list')->get();
        if ($links) {
            return $this->Success('Links Fetched Successfully', $links);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateLink = Validator::make($request->all(), [
            'url'          => 'required|url|min:10|max:60',
            'description'  => 'required|string|max:200',
            'link_list_id' => 'required|exists:link_lists,id'
        ]);

        if ($validateLink->fails()) {
            return $this->ErrorResponse($validateLink);
        }

        $link = Link::create($request->only(
            [
                'url',
                'description',
                'link_list_id'
            ]
        ));

        return $this->Success('Link Created Successfully', $link);
    }

    public function get($id)
    {
        $link = Link::find($id);
        if ($link) {
            return $this->Success('Link Fetched Successfully', $link);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateLink = Validator::make($request->all(), [
            'url'          => 'required|url|min:10|max:60',
            'description'  => 'required|string|max:200',
        ]);

        if ($validateLink->fails()) {
            return $this->ErrorResponse($validateLink);
        }

        $link = Link::find($id);

        if ($link) {
            $link->update($request->only(
                [
                    'url',
                    'description'
                ]
            ));

            return $this->Success('Link Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $link = Link::find($id);
        if ($link) {
            $link->delete();
            return $this->Success('Link Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
