<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Profile;
use App\Traits\ResponceMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ResponceMessage;

    public function list()
    {
        $products = Product::with('images')->has('images')->get();
        if ($products) {
            return $this->Success('Products Fetched Successfully', $products);
        }
        return $this->DataNotFound();
    }

    public function create(Request $request)
    {
        $validateProduct = Validator::make($request->all(), [
            'product_name' => 'required|string|max:40|unique:products,product_name',
            'price'        => 'required|numeric|min:1',
            'image_path'   => 'required|array|max:100'
        ]);

        if ($validateProduct->fails()) {
            return $this->ErrorResponse($validateProduct);
        }

        $product = Product::create($request->only(
            [
                'product_name',
                'price'
            ]
        ));

        foreach ($request->image_path as $image) {
            $profile = new Profile;
            $profile->image_path = $image;
            $product->images()->save($profile);
        }

        return $this->Success('Product Created Successfully', $product);
    }

    public function get($id)
    {
        $product = Product::find($id);
        if ($product) {
            return $this->Success('Product Fetched Successfully', $product);
        }
        return $this->DataNotFound();
    }

    public function update(Request $request, $id)
    {
        $validateProduct = Validator::make($request->all(), [
            'product_name' => 'required|string|max:40|unique:products,product_name',
            'price'        => 'required|numeric|min:1',
            'id'           => 'required|exists:profiles,id',
            'image_path'   => 'required|max:100'
        ]);

        if ($validateProduct->fails()) {
            return $this->ErrorResponse($validateProduct);
        }

        $product = Product::find($id);

        if ($product) {
            $product->update($request->only(
                [
                    'product_name',
                    'price'
                ]
            ));

            $product->images()->updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'image_path' => $request->image_path
                ]
            );

            return $this->Success('Product Updated Successfully');
        }
        return $this->DataNotFound();
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->with('images')->delete();
            return $this->Success('Product Deleted Successfully');
        }
        return $this->DataNotFound();
    }
}
