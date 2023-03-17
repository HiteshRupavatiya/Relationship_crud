<?php

namespace App\Http\Controllers;

use App\Models\LinkList;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinkListController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $linkLists = LinkList::with('links')->get();
        if ($linkLists) {
            return $this->Success('Link Lists Fetched Successfully', $linkLists);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateLinkList = Validator::make($request->all(), [
            'title'        => 'required|string|min:5|max:50',
            'slug'         => 'required|alpha_dash|unique:link_lists,slug',
            'description'  => 'required|string|max:200',
        ]);

        if ($validateLinkList->fails()) {
            return $this->ErrorResponse($validateLinkList);
        }

        $linkList = LinkList::create($request->only(
            [
                'title',
                'slug',
                'description'
            ]
        ));

        return $this->Success('Link List Created Successfully', $linkList);
    }

    public function get($id)
    {
        $linkList = LinkList::find($id);
        if ($linkList) {
            return $this->Success('Link List Fetched Successfully', $linkList);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateLinkList = Validator::make($request->all(), [
            'title'        => 'required|string|min:5|max:50',
            'slug'         => 'required|alpha_dash|unique:link_lists,slug',
            'description'  => 'required|string|max:200',
        ]);

        if ($validateLinkList->fails()) {
            return $this->ErrorResponse($validateLinkList);
        }

        $linkList = LinkList::find($id);

        if ($linkList) {
            $linkList->update($request->only(
                [
                    'title',
                    'slug',
                    'description'
                ]
            ));

            return $this->Success('Link List Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $linkList = LinkList::find($id);
        if ($linkList) {
            $linkList->delete();
            return $this->Success('Link List Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
