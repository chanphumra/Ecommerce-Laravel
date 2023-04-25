<?php

namespace App\Http\Controllers;

use App\Models\Aboutus;
use Illuminate\Http\Request;

class AboutusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about_us = Aboutus::all();
        return response()->json([
            'result' => $about_us
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $about_us = new Aboutus();
        $about_us->name = $request->name;
        $about_us->position = $request->position;
        $about_us->description = $request->description;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $image_name = time() . rand() . "." . $extension;
            $uploads_path = "uploads/about_us/";
            $image_url = "/" . $uploads_path . $image_name;
            $file->move($uploads_path, $image_name);
            $about_us->image = $image_url;
        }
        $about_us->save();

        return response()->json([
            "success" => true,
            "insert_id" => $about_us->id
        ],200);
        echo "hello world";
        return "hello world";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $about_us = Aboutus::find($id);
        
        return response()->json([
            "result" => $about_us
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aboutus $about_us)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $about_us = Aboutus::find($id);
        if ($about_us) {
            $about_us->name = $request->name;
            $about_us->position = $request->position;
            $about_us->description = $request->description;

            if ($request->hasFile('image')) {
                /*======= delete old image ======*/
                if (file_exists(substr($about_us->image, 1))) unlink(substr($about_us->image, 1));

                /*======= update database ======*/
                $file = $request->file('image');
                $extention = strtolower($file->getClientOriginalExtension());
                $image_name = time() . rand() . "." . $extention;
                $uploads_path = "uploads/about_us/";
                $image_url = "/" . $uploads_path . $image_name;
                $file->move($uploads_path, $image_name);
                $about_us->image = $image_url;
            }
            $about_us->save();
            return response()->json([
                "success" => true
            ], 200);
        } 
        return response()->json([
            "message" => "about_us not found"
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $about_us = Aboutus::find($id);
        if ($about_us) {
            /*======= delete image ======*/
            if (file_exists(substr($about_us->image, 1))) unlink(substr($about_us->image, 1));

            /*======= delete database ======*/
            $about_us->delete();
            return response()->json([
                "success" => true
            ], 200);
        }
        return response()->json([
            "message" => "Aboutus not found"
        ], 400);
    }
}
