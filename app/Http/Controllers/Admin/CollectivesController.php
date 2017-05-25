<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Collective;
use Carbon\Carbon;


class CollectivesController extends Controller
{

    public function index()
    {
        return view('admin.collective');
    }

    public function collectivesList()
    {
        return view('admin.collectives_list');
    }

    public function create(Request $request)
    {
        # входные параметры для создания коллектива
        $name = $request -> input('name');
        $description = $request -> input('description');
        $image = $request -> input('image');
        $deputy = $request -> input('deputy');
        $place = $request -> input('place');
        $tags = json_encode(explode(",", $request->input('tags')));
        $social = json_decode($request->input('social'));
        $alias = trim(substr(CMS::rus2translit($name), 0, 100));

        # сохраняем новую новость в бд
        $item =
            [
                'name' => $name,
                'description' => $description,
                'alias' =>  str_replace(' ', '_', $alias),
                'place' => $place,
                'deputy' => $deputy,
                'image' => $image,
                'tags' => $tags,
                'social' => json_encode($social)
            ];

        $out = Collective::create($item);

        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $out
        ]);
    }

    public function update(Request $request)
    {
        # входные параметры для создания коллектива
        $id = $request -> input('id');
        $name = $request -> input('name');
        $description = $request -> input('description');
        $image = $request -> input('image');
        $deputy = $request -> input('deputy');
        $place = $request -> input('place');
        $tags = json_encode(explode(",", $request->input('tags')));
        $social = json_decode($request->input('social'));
        $alias = trim(substr(CMS::rus2translit($name), 0, 100));

        $out =  Collective::where('id', (int)($id))->update(
            [
                'name' => $name,
                'description' => $description,
                'alias' =>  str_replace(' ', '_', $alias),
                'place' => $place,
                'deputy' => $deputy,
                'image' => $image,
                'tags' => $tags,
                'social' => json_encode($social)
            ]
        );

        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $out
        ]);
    }

    public function item($id)
    {
        $id = Collective::where('id', (int)($id)) -> value('id');

        # если нет id -> 404
        if ($id == false){
            abort(404);
        }

        # забираем массив параметров событий
        $collective_params = Collective::where('id', $id) -> get();

        $name =  $collective_params[0]['name'];
        $description = $collective_params[0]['description'];
        $image = $collective_params[0]['image'];
        $deputy = $collective_params[0]['deputy'];
        $place = $collective_params[0]['place'];
        $tags = implode(',',json_decode($collective_params[0]['tags']));
        $social = $collective_params[0]['social'];


        # выводим
        return view('admin.collectives_item',
            [
                'id' => $id,
                'name' => $name,
                'description' => $description,
                'image' => $image,
                'depute' => $deputy,
                'place' => $place,
                'tags' => $tags,
                'social' => $social,
            ]
        );
    }

    public function api()
    {
        $collectives = Collective::get();
        /**
        if (!empty($places)){
        foreach ($places as $place){
        $place['tags'] = json_encode($place['tags']);
        }
        }
         **/
        return response()->json([
            'response' => $collectives
        ]);
    }

    public function upload(Request $request)
    {
        if (Input::file()){
            $extension = $request->image->extension();
            $destinationPath = public_path().config('conf.dirs.collectives');
            $name = rtrim(strtr(base64_encode($request->image->path()), '+/', '-_'), '=');
            $img = time().'_'.$name.".".$extension;
            $request->image->move($destinationPath, $img);

            return response()->json([
                "response" => config('conf.dirs.collectives').$img
            ]);

        } else {
            return response()->json([
                "response" => "There is no input file"
            ]);
        }
    }

}