<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Place;
use App\Models\Event;

class MainController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }


    public function rubricItem($rubric, $id)
    {
        return $rubric . $id;
    }


    public function galleryUpload(Request $request)
    {
        $files = Input::file();
        $arr_urls = [];

        foreach ($files as $file){
            $ext = $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();
        }

        return response()->json([
            "response" => $files
        ]);
    }



}