<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        return $rubric.$id;
    }

    /**
     *  todo:Загрузка галереи изображений
     */
    public function galleryUpload(Request $request)
    {
        $image_urls = [];

        foreach ($request->images as $file) {
            array_push($image_urls, $file);
        }

        return response()->json([
            "response" => $image_urls
        ]);
    }
}