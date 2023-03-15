<?php

namespace App\Http\Controllers;

use App\Models\LinkList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinkListController extends Controller
{
    public function list()
    {
        $linkLists = LinkList::with('links')->get();
        return response()->json([
            'status'     => true,
            'message'    => 'Link Lists Fetched Successfully',
            'link_lists' => $linkLists
        ]);
    }

    public function create(Request $request)
    {
        $validateLinkList = Validator::make($request->all(), [
            'title'        => 'required|string|min:5|max:50',
            'slug'         => 'required|alpha_dash|unique:link_lists,slug',
            'description'  => 'required|string|max:200',
        ]);

        if ($validateLinkList->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validateLinkList->errors()
            ]);
        }

        $linkList = LinkList::create($request->only(
            [
                'title',
                'slug',
                'description'
            ]
        ));

        return response()->json([
            'status'    => true,
            'message'   => 'Link List Created Successfully',
            'link_list' => $linkList
        ]);
    }

    public function get($id)
    {
        $linkList = LinkList::findOrFail($id);
        if ($linkList) {
            return response()->json([
                'status'    => true,
                'message'   => 'Link List Fetched Successfully',
                'link_list' => $linkList
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateLinkList = Validator::make($request->all(), [
            'title'        => 'required|string|min:5|max:50',
            'slug'         => 'required|alpha_dash|unique:link_lists,slug',
            'description'  => 'required|string|max:200',
        ]);

        if ($validateLinkList->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validateLinkList->errors()
            ]);
        }

        $linkList = LinkList::findOrFail($id);

        $linkList->update($request->only(
            [
                'title',
                'slug',
                'description'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Link List Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $linkList = LinkList::findOrFail($id);
        if ($linkList) {
            $linkList->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Link List Deleted Successfully'
            ]);
        }
    }
}
