<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $footer = Footer::all();
        return response()->json([
            "result" => $footer
        ], 200);
    }

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

}
