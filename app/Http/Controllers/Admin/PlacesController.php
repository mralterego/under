<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Place;
use Carbon\Carbon;


class PlacesController extends Controller
{

    public function index()
    {
        return view('admin.place');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            "title" => "filled|required",
            "alias" => "filled|required",
            "site" => "filled|required",
            "address" => "filled|required",
            "coordinates" => "filled|required",
            "description" => "filled|required",
            "worktime" => "filled",
            "deputy" => "filled",
            "tags" => "filled",
            "image" => "filled",
            "gallery" => "filled",
            "published" => "filled",
        ]);

        # входные параметры для создания события
        $title = $request -> input('title');
        $alias = $request -> input('alias');
        $site = $request -> input('site');
        $address = $request -> input('address');
        $coordinates = $request -> input('coordinates');
        $description= $request -> input('description');
        $worktime = $request -> input('worktime');
        $deputy = $request -> input('deputy');
        $image = $request -> input('image');
        $gallery = $request -> input('gallery');
        $tags = explode(",", $request->input('tags'));
        $published = $request -> input('published') === "true" ? true : false;
        $rating = [];

        # сохраняем новую новость в бд
        $item =
            [
                'title' => $title,
                'alias' => $alias,
                'site' => $site,
                'deputy' => $deputy,
                'address' => $address,
                'coordinates' => $coordinates,
                'description' => $description,
                'worktime' => $worktime,
                'image' => $image,
                'gallery' => $gallery,
                'tags' => $tags,
                'rating' => $rating,
                'published' => $published
            ];

        $out = Event::create($item);

        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $out
        ]);
    }

}