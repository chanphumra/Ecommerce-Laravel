<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $footer = Footer::all();
        return response()->json([
            "result" => $footer
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Footer $footer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Footer $footer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Footer $footer)
    {
        $footer = Footer::find($request->id);
        if ($footer) {
            $footer->title = $request->title;
            $footer->description = $request->description;
            $footer->text1 = $request->text1;
            $footer->text2 = $request->text2;
            $footer->text3 = $request->text3;
            $footer->text4 = $request->text4;

            $footer->save();
            return response()->json([
                "success" => true
            ], 200);
        } 
        return response()->json([
            "message" => "footer not found"
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Footer $footer)
    {
        //
    }
}
