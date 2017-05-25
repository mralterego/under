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

    public function eventsList()
    {
        return view('admin.events_list');
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

    public function update(Request $request)
    {
        /**
        $this->validate($request, [
            'id' => 'required|filled',
            'title' => 'required|filled',
            'date' => 'required|filled',
            'link' => 'required|filled',
            'image' => 'required|filled',
            'place' => 'required|filled',
            'price' => 'required|filled',
            'tags' => 'required|filled',
            'content' => 'filled',
            'published' => 'filled'
        ]);
         **/

        # входные параметры для редактирования новости
        $id =  $request -> input('id');
        $event_title = $request -> input('title');
        $event_link = urlencode($request -> input('link'));
        $place = $request -> input('place');
        $price = $request -> input('price');
        $tags = $request -> input('tags');
        $image = $request -> input('image');
        $publish = $request -> input('published') === '1' ? true : false;

        $content = $request -> input('content');
        $content = str_replace("\n", "<br>", $content);

       $out =  Event::where('id', (int)($id))->update(
            [
                'title' => $event_title,
                'link' => $event_link,
                'author' => 'admin',
                'date' => date_format(date_create($request -> input('date')), 'Y-m-d H:i:s.00000'),
                'place' => $place,
                'price' => $price,
                'image' => $image,
                'tags' => json_encode(explode(",", $tags)),
                'published' => $publish,
                'content' => $content,
            ]
        );

        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $out
        ]);
    }

    public function item($id)
    {
        $id = Event::where('id', (int)($id)) -> value('id');

        # если нет id -> 404
        if ($id == false){
            abort(404);
        }

        # забираем массив параметров событий
        $event_params = Event::where('id', $id) -> get();

        $title =  $event_params[0]['title'];
        $link = $event_params[0]['link'];
        $image = $event_params[0]['image'];
        $place = $event_params[0]['place'];
        $price = $event_params[0]['price'];
        $tags = implode(',', $event_params[0]['tags']);
        $date = date_format(date_create($event_params[0]['date']), 'd.m.Y');
        $published = $event_params[0]['published'];

        # убираем лишнее из контента, иначе сломается
        $content = str_replace("\n", "<br/>", $event_params[0]['content']);

        # в колонке custom, которая должна быть BOOLEAN, по какой-то непонятной хранится также и NULL, поэтому делаем NULL в false
        if ($published == NULL) {
            $published = false;
        }

        # преобразуем true/false в 1/0
        $intPublished = (int)($published);

        # выводим
        return view('admin.events_item',
            [
                'id' => $id,
                'title' => $title,
                'content' => $content,
                'link' => $link,
                'image' => $image,
                'place' => $place,
                'price' => $price,
                'tags' => $tags,
                'date' => $date,
                'published' => $intPublished,
            ]
        );
    }

    public function api(Request $request)
    {
        $events = Event::get();

        if (!empty($events)){
            foreach ($events as $event){
                $event['date_formatted'] = date("d.m.Y", strtotime($event['date']));
            }
        }
        return response()->json([
            'response' => $events
        ]);

    }


}