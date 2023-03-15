<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    public function list()
    {
        $links = Link::with('link_list')->get();
        return response()->json([
            'status'  => true,
            'message' => 'Links Fetched Successfully',
            'links'   => $links
        ]);
    }

    public function create(Request $request)
    {
        $validateLink = Validator::make($request->all(), [
            'url'          => 'required|url|min:10|max:60',
            'description'  => 'required|string|max:200',
            'link_list_id' => 'required|exists:link_lists,id'
        ]);

        if ($validateLink->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validateLink->errors()
            ]);
        }

        $link = Link::create($request->only(
            [
                'url',
                'description',
                'link_list_id'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Link Created Successfully',
            'link'    => $link
        ]);
    }

    public function get($id)
    {
        $link = Link::findOrFail($id);
        if ($link) {
            return response()->json([
                'status'  => true,
                'message' => 'Link Fetched Successfully',
                'link'    => $link
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateLink = Validator::make($request->all(), [
            'url'          => 'required|url|min:10|max:60',
            'description'  => 'required|string|max:200',
        ]);

        if ($validateLink->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validateLink->errors()
            ]);
        }

        $link = Link::findOrFail($id);

        $link->update($request->only(
            [
                'url',
                'description'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Link Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $link = Link::findOrFail($id);
        if ($link) {
            $link->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Link Deleted Successfully'
            ]);
        }
    }
}
