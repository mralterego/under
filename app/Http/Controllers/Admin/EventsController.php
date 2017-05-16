<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Event;
use Carbon\Carbon;


class EventsController extends Controller
{

    public function index()
    {
        return view('admin.events');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            "title" => "filled|required",
            "place" => "filled|required",
            "price" => "filled|required",
            "link" => "filled|required",
            "image" => "filled|required",
            "content" => "filled",
            "tags" => "filled",
            "date" => "filled",
            "published" => "filled",
        ]);

        # входные параметры для создания события
        $title = $request -> input('title');
        $link = $request -> input('link');
        $image = $request -> input('image');
        $date = $request -> input('date');
        $place = $request -> input('place');
        $price = $request -> input('price');
        $content = $request -> input('content');
        $tags = explode(",", $request->input('tags'));
        $published = $request -> input('published') === "true" ? true : false;

        # сохраняем новую новость в бд
        $item =
            [
                'title' => $title,
                'content' => $content,
                'link' => $link,
                'author' => 'admin',
                'image' => $image,
                'place' => $place,
                'price' => $price,
                'tags' => $tags,
                'date' => date_format(date_create($date), 'Y-m-d H:i:s.00000'),
                'published' => $published
            ];

        $out = Event::create($item);

        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $out
        ]);
    }

    public function item($id)
    {

    }


    /**
     *  Загрузка изображения
     */
    public function upload(Request $request)
    {
        if (Input::file()){
            $extension = $request->image->extension();
            $destinationPath = public_path().config('conf.dirs.events');
            $name = rtrim(strtr(base64_encode($request->image->path()), '+/', '-_'), '=');
            $img = time().'_'.$name.".".$extension;
            $request->image->move($destinationPath, $img);

            return response()->json([
                "response" => config('conf.dirs.events').$img
            ]);

        } else {
            return response()->json([
                "response" => "There is no input file"
            ]);
        }
    }

    public function api(Request $request)
    {

    }
}