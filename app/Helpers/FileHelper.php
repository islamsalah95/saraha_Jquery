<?php

namespace App\Helpers;

use Illuminate\Http\Request;


// notes  you must pass in method        
//  $path=FileHelper::storeFile($request->file('image'));
//  validation : 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048'
//  <input type="file" name="image" id="image">
//  <input type="file" name="image" id="image">
// enctype="multipart/form-data"


class FileHelper
{
    public static function storeFile($file)
    {

        $myimage = $file->getClientOriginalName();
        $file->move(public_path( 'images'), $myimage);

        return  asset('images').'/'.$myimage ;

    }

    public function removeFile($file)
    {
    if(file_exists(public_path('images'.'/'.$file))){
    unlink(public_path('images'.'/'.$file));
    }
    }
}
