<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Event;
use Carbon\Carbon;


class MainController extends Controller
{


    /**
     *  Загрузка галереи изображений
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