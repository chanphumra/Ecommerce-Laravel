<?php

namespace App\Http\Controllers;

use App\Models\Profilesetting;
use Illuminate\Http\Request;

class ProfilesettingController extends Controller
{
    public function index()
    {
        $profile_setting = Profilesetting::all();
        return response()->json([
            "result" => $profile_setting
        ], 200);
    }

    public function show(string $id)
    {
        $profile_setting = Profilesetting::find($id);
        
        return response()->json([
            "result" => $profile_setting
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $profile_setting = Profilesetting::find($id);
        if ($profile_setting) {
            $profile_setting->name = $request->name;
            $profile_setting->city = $request->city;
            $profile_setting->country = $request->country;
            $profile_setting->phone = $request->phone;
            $profile_setting->email = $request->email;

            if ($request->hasFile('image')) {
                /*======= delete old image ======*/
                if (file_exists(substr($profile_setting->image, 1))) unlink(substr($profile_setting->image, 1));

                /*======= update database ======*/
                $file = $request->file('image');
                $extention = strtolower($file->getClientOriginalExtension());
                $image_name = time() . rand() . "." . $extention;
                $uploads_path = "uploads/profile_setting/";
                $image_url = "/" . $uploads_path . $image_name;
                $file->move($uploads_path, $image_name);
                $profile_setting->image = $image_url;
            }
            $profile_setting->save();
            return response()->json([
                "success" => true
            ], 200);
        } 
        return response()->json([
            "message" => "profile_setting not found"
        ], 400);
    }
}
