<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Image;

class FileController extends Controller {

    public function getResizeImage()
    {
        return view('resizeimage');
    }

    public function postResizeImage(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:11024',
        ]);

        $photo = $request->file('photo');
        $imagename = time().'.'.$photo->getClientOriginalExtension(); 
   
        $destinationPath = public_path('thumbnail').'\\'.$imagename; 
        $imageinfo = getimagesize($photo);
        $height = $imageinfo[1];
        $width  = $imageinfo[0];
        $thumb_width = 200;
        $thumb_height = ($height*$thumb_width)/$width;
        $thumb_img = Image::make($photo->getRealPath())->resize($thumb_width, $thumb_height);
        $thumb_img->save($destinationPath,80);
                    
        $destinationPath = public_path('/normal_images');
        $photo->move($destinationPath, $imagename);

        return back()
            ->with('success','Image Upload successful')
            ->with('imagename',$imagename);
    }
} 
