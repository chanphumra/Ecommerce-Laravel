<?php

namespace App\Http\Controllers;

use App\Models\Slideshow;
use Illuminate\Http\Request;

class SlideshowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $slideshow = Slideshow::all();
        return response()->json([
            "result" => $slideshow
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $slideshow = new Slideshow();
        $slideshow->title = $request->title;
        $slideshow->text = $request->text;
        $slideshow->link = $request->link;

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

    /**
     * Display the specified resource.
     */
    public function show(Slideshow $slideshow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slideshow $slideshow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slideshow $slideshow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slideshow $slideshow)
    {
        //
    }
}
