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

    public function placesList()
    {
        return view('admin.places_list');
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
        $tags = $request->input('tags');
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
                'tags' => json_encode(explode(",", $tags)),
                'rating' => json_encode($rating),
                'published' => $published
            ];

        $out = Place::create($item);

        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $out
        ]);
    }

    public function item($id)
    {
        $id = Place::where('id', (int)($id)) -> value('id');

        # если нет id -> 404
        if ($id == false){
            abort(404);
        }
        # забираем массив параметров мест
        $place_params = Place::where('id', $id) -> get();

        $title =  $place_params[0]['title'];
        $alias = $place_params[0]['alias'];
        $image = $place_params[0]['image'];
        $site = $place_params[0]['site'];
        $address = $place_params[0]['address'];
        $deputy = $place_params[0]['deputy'];
        $gallery = $place_params[0]['gallery'];
        $worktime = $place_params[0]['worktime'];
        $coordinates = $place_params[0]['coordinates'];
        $tags = implode(',', $place_params[0]['tags']);
        $published = $place_params[0]['published'];

        $description = str_replace("\n", "<br/>", $place_params[0]['description']);

        if ($published == NULL) {
            $published = false;
        }
        # преобразуем true/false в 1/0
        $intPublished = (int)($published);

        # выводим
        return view('admin.places_item',
            [
                'id' => $id,
                'title' => $title,
                'alias' => $alias,
                'image' => $image,
                'site' => $site,
                'address' => $address,
                'deputy' => $deputy,
                'gallery' => $gallery,
                'worktime' => $worktime,
                'tags' => $tags,
                'description' => $description,
                'coordinates' => $coordinates,
                'published' => $intPublished,
            ]
        );
    }


    public function update(Request $request)
    {

        # входные параметры для создания события
        $id = $request -> input('id');
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
        $tags = $request->input('tags');
        $published = $request -> input('published') === "true" ? true : false;
        $rating = [];

        # сохраняем новую новость в бд
        $out =  Place::where('id', (int)($id))->update([
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
            'tags' => json_encode(explode(",", $tags)),
            'rating' => json_encode($rating),
            'published' => $published
        ]);

        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $out
        ]);
    }

    /**
     *  Все места
     */
    public function api()
    {
        $places = Place::get();
        /**
        if (!empty($places)){
            foreach ($places as $place){
               $place['tags'] = json_encode($place['tags']);
            }
        }
         **/
        return response()->json([
            'response' => $places
        ]);
    }

    /**
     *  Загрузка изображения
     */
    public function upload(Request $request)
    {
        if (Input::file()){
            $extension = $request->image->extension();
            $destinationPath = public_path().config('conf.dirs.places');
            $name = rtrim(strtr(base64_encode($request->image->path()), '+/', '-_'), '=');
            $img = time().'_'.$name.".".$extension;
            $request->image->move($destinationPath, $img);

            return response()->json([
                "response" => config('conf.dirs.places').$img
            ]);

        } else {
            return response()->json([
                "response" => "There is no input file"
            ]);
        }
    }




}