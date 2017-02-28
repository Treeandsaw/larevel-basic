<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\image;
use Storage;

// php artisan make:model image

class ImageController extends Controller
{
    public function index(){
    	return view('upload');
    }

    public function upload(Request $request)
    {
        // dd($request); 
        $filename=$request->file('image')->getClientOriginalName();
        Storage::put('upload/images/' .$filename, file_get_contents($request->file('image')->getRealpath()));

        $image = new image;
        $image->name = $request->name;
        $image->image = $filename;
        $image->save();
        return view('upload');
    }

}