<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::with('images')->has('images')->get();
        return response()->json([
            'status'   => true,
            'message'  => 'Products Fetched Successfully',
            'products' => $products
        ]);
    }

    public function create(Request $request)
    {
        $validateProduct = Validator::make($request->all(), [
            'product_name' => 'required|string|max:40|unique:products,product_name',
            'price'        => 'required|numeric|min:1'
        ]);

        if ($validateProduct->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateProduct->errors()
            ]);
        }

        $product = Product::create($request->only(
            [
                'product_name',
                'price'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Product Created Successfully',
            'product' => $product
        ]);
    }

    public function get($id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            return response()->json([
                'status'  => true,
                'message' => 'Product Fetched Successfully',
                'product' => $product
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validateProduct = Validator::make($request->all(), [
            'product_name' => 'required|string|max:40|unique:products,product_name',
            'price'        => 'required|numeric|min:1'
        ]);

        if ($validateProduct->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Errors',
                'errors'  => $validateProduct->errors()
            ]);
        }

        $product = Product::findOrFail($id);

        $product->update($request->only(
            [
                'product_name',
                'price'
            ]
        ));

        return response()->json([
            'status'  => true,
            'message' => 'Product Updated Successfully',
        ]);
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            $product->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Product Deleted Successfully',
            ]);
        }
    }
}
