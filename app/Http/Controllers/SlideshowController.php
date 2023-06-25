<?php

namespace App\Http\Controllers;

use App\Models\Slideshow;
use Illuminate\Http\Request;

class SlideshowController extends Controller
{
    public function index()
    {
        $slideshow = Slideshow::all();
        return response()->json([
            "result" => $slideshow
        ], 200);
    }

    public function store(Request $request)
    {
        $slideshow = new Slideshow();
        $slideshow->title = $request->title;
        $slideshow->text = $request->text;
        $slideshow->link = $request->link;
        $slideshow->enable = $request->enable;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $image_name = time() . rand() . "." . $extension;
            $uploads_path = "uploads/slideshow/";
            $image_url = "/" . $uploads_path . $image_name;
            $file->move($uploads_path, $image_name);
            $slideshow->image = $image_url;
        }
        $slideshow->save();

        return response()->json([
            "success" => true,
            "insert_id" => $slideshow->id
        ],200);
    }

    public function show(string $id)
    {
        //
        $slideshow = Slideshow::find($id);
        
        return response()->json([
            "result" => $slideshow
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $slideshow = Slideshow::find($id);
        if ($slideshow) {
            $slideshow->title = $request->title;
            $slideshow->text = $request->text;
            $slideshow->link = $request->link;
            $slideshow->enable = $request->enable;

            if ($request->hasFile('image')) {
                /*======= delete old image ======*/
                if (file_exists(substr($slideshow->image, 1))) unlink(substr($slideshow->image, 1));

                /*======= update database ======*/
                $file = $request->file('image');
                $extention = strtolower($file->getClientOriginalExtension());
                $image_name = time() . rand() . "." . $extention;
                $uploads_path = "uploads/slideshow/";
                $image_url = "/" . $uploads_path . $image_name;
                $file->move($uploads_path, $image_name);
                $slideshow->image = $image_url;
            }
            $slideshow->save();
            return response()->json([
                "success" => true
            ], 200);
        } 
        return response()->json([
            "message" => "slideshow not found"
        ], 400);
    }

    public function destroy(string $id)
    {
        $slideshow = Slideshow::find($id);
        if ($slideshow) {
            /*======= delete image ======*/
            if (file_exists(substr($slideshow->image, 1))) unlink(substr($slideshow->image, 1));

            /*======= delete database ======*/
            $slideshow->delete();
            return response()->json([
                "success" => true
            ], 200);
        }
        return response()->json([
            "message" => "slideshow not found"
        ], 400);
    }

    public function updateEnable(Request $request, string $id){
        $slideshow = Slideshow::find($id);
        if ($slideshow) {
            $slideshow->enable = $request->enable;
            $slideshow->save();

            return response()->json([
                "success" => true,
                "message" => "updated"
            ], 200);
        }
        return response()->json([
            "success" => false,
            "message" => "slideshow not found"
        ], 400);
    }
}
