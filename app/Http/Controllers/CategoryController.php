<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json([
            "result" => $category
        ], 200);
    }

    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extention = strtolower($file->getClientOriginalExtension());
            $image_name = time() . rand() . "." . $extention;
            $uploads_path = "uploads/category/";
            $image_url = "/" . $uploads_path . $image_name;
            $file->move($uploads_path, $image_name);
            $category->image = $image_url;
        }
        $category->save();

        return response()->json([
            "success" => true,
            "insert_id" => $category->id
        ], 200);
    }

    public function show(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->products;
            return response()->json([
                "result" => $category
            ], 200);
        } 
        return response()->json([
            "message" => "category not found"
        ], 400);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->name = $request->name;
            $category->description = $request->description;

            if ($request->hasFile('image')) {
                /*======= delete old image ======*/
                if (file_exists(substr($category->image, 1))) unlink(substr($category->image, 1));

                /*======= update database ======*/
                $file = $request->file('image');
                $extention = strtolower($file->getClientOriginalExtension());
                $image_name = time() . rand() . "." . $extention;
                $uploads_path = "uploads/category/";
                $image_url = "/" . $uploads_path . $image_name;
                $file->move($uploads_path, $image_name);
                $category->image = $image_url;
            }
            $category->save();
            return response()->json([
                "success" => true
            ], 200);
        } 
        return response()->json([
            "message" => "category not found"
        ], 400);
    }

    public function destroy(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            /*======= delete image ======*/
            if (file_exists(substr($category->image, 1))) unlink(substr($category->image, 1));

            /*======= delete database ======*/
            $category->delete();
            return response()->json([
                "success" => true
            ], 200);
        }
        return response()->json([
            "message" => "category not found"
        ], 400);
    }
}
