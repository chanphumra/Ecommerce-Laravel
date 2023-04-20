<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with('category')->get();
        return response()->json([
            "result" => $product
        ], 200);
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->c_id = $request->c_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->sale_price = $request->sale_price;
        $product->qty = $request->qty;
        $product->discount = $request->discount;
        $product->image1 = "";
        $product->image2 = "";
        $product->image3 = "";

        if ($request->hasFile('image1') && $request->hasFile('image2') && $request->hasFile('image3')) {
            $imageArray = [$request->file('image1'), $request->file('image2'), $request->file('image3')];
            for ($index = 0; $index < count($imageArray); $index++) {
                $file = $imageArray[$index];
                $extention = strtolower($file->getClientOriginalExtension());
                $image_name = time() . rand() . "." . $extention;
                $uploads_path = "uploads/product/";
                $image_url = "/" . $uploads_path . $image_name;
                $file->move($uploads_path, $image_name);
                if ($index == 0) $product->image1 = $image_url;
                if ($index == 1) $product->image2 = $image_url;
                if ($index == 2) $product->image3 = $image_url;
            }
        }
        $product->save();

        return response()->json([
            "success" => true,
            "insert_id" => $product->id
        ], 200);
    }

    public function show(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->category;
            return response()->json([
                "result" => $product
            ], 200);
        } else {
            return response()->json([
                "message" => "product not found"
            ], 400);
        }
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->c_id = $request->c_id;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->sale_price = $request->sale_price;
            $product->qty = $request->qty;
            $product->discount = $request->discount;

            if ($request->hasFile('image1') && $request->hasFile('image2') && $request->hasFile('image3')) {

                /*========== delete old image ==========*/
                if (file_exists(substr($product->image1, 1))) unlink(substr($product->image1, 1));
                if (file_exists(substr($product->image2, 1))) unlink(substr($product->image2, 1));
                if (file_exists(substr($product->image3, 1))) unlink(substr($product->image3, 1));

                /*========== update database ==========*/
                $imageArray = [$request->file('image1'), $request->file('image2'), $request->file('image3')];
                for ($index = 0; $index < count($imageArray); $index++) {
                    $file = $imageArray[$index];
                    $extention = strtolower($file->getClientOriginalExtension());
                    $image_name = time() . rand() . "." . $extention;
                    $uploads_path = "uploads/product/";
                    $image_url = "/" . $uploads_path . $image_name;
                    $file->move($uploads_path, $image_name);
                    if ($index == 0) $product->image1 = $image_url;
                    if ($index == 1) $product->image2 = $image_url;
                    if ($index == 2) $product->image3 = $image_url;
                }
            }

            $product->save();
            return response()->json([
                "success" => true
            ], 200);
        }
        return response()->json([
            "message" => "product not found"
        ], 400);
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            /*======= delete image ======*/
            if (file_exists(substr($product->image1, 1))) unlink(substr($product->image1, 1));
            if (file_exists(substr($product->image2, 1))) unlink(substr($product->image2, 1));
            if (file_exists(substr($product->image3, 1))) unlink(substr($product->image3, 1));

            /*======= delete database ======*/
            $product->delete();
            return response()->json([
                "success" => true
            ], 200);
        }
        return response()->json([
            "message" => "product not found"
        ], 400);
    }

    public function clearStock(Request $request, string $id)
    {
        $qty = $request->qty;
        $product = Product::find($id);
        if($product){
            $product->qty = $product->qty - $qty;
            $product->save();

            return response()->json([
                "message" => "update stock success"
            ], 200);
        }

        return response()->json([
            "message" => "product not found"
        ], 400);
    }
}
