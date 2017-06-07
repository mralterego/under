<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Event;
use Carbon\Carbon;


class ParserController extends Controller
{

    public function index()
    {
        return view('admin.parser');
    }

    public function api()
    {
        $parsers = [config('parsers.dot'), config('parsers.gribych'), config('parsers.psytribe')];

        return response() -> json($parsers);
    }


    public function parseAndSave()
    {

        $today = Carbon::today();
        $titles = Event::pluck('title')->toArray();
        $events = [];


        $eventsPsytribe = CMS::parserPsytribe(config('parsers.psytribe.url'), config('parsers.psytribe.alias'), config('parsers.psytribe.events_path'), config('parsers.psytribe.title_path'), config('parsers.psytribe.date_path'), config('parsers.psytribe.link_path'), config('parsers.psytribe.img_path'), config('parsers.psytribe.article_path'));
        $eventsDot = CMS::parserDot(config('parsers.dot.url'), config('parsers.dot.alias'), config('parsers.dot.events_path'), config('parsers.dot.title_path'), config('parsers.dot.date_path'), config('parsers.dot.link_path'), config('parsers.dot.img_path'), config('parsers.dot.article_path'));
        $eventsGribych = CMS::parserGribych(config('parsers.gribych.url'), config('parsers.gribych.alias'), config('parsers.gribych.events_path'), config('parsers.gribych.title_path'), config('parsers.gribych.date_path'), config('parsers.gribych.link_path'), config('parsers.gribych.img_path'), config('parsers.gribych.article_path'));

        # объединяем массивы с событиями
        $events = array_merge($eventsPsytribe, $eventsDot, $eventsGribych);

        if (!empty($events)){
            foreach ($events as $k => $event){
                # если дата в будущем и нет таких записей заголовокоа прежде
                if ($event['date'] >= $today AND !in_array($event['title'], $titles)){
                    $publish = true;
                    if (!isset($event['image']) AND !isset($event['link'])){
                        $event['image'] = "";
                        $event['link'] = "";
                        $publish = false;
                    }
                    # формируем событие и сохраняем
                    $item = [
                        'title' => $event['title'],
                        'content' => $event['article'],
                        'image' => $event['image'],
                        'author' => 'parser',
                        'price' => 'none',
                        'link' => $event['link'],
                        'place' => $event['place'],
                        'date' => $event['date'],
                        'tags' => $event['tags'],
                        'published' => $publish
                    ];
                    Event::create($item);
                }
            }
        }


    }

    public function testDot(Request $request)
    {

        $this->validate($request, [
            'url' => 'required|filled',
            'alias' => 'required|filled',
            'place' => 'required|filled',
            'events_path' => 'required|filled',
            'title_path' => 'required|filled',
            'date_path' => 'required|filled',
            'img_path' => 'required|filled',
            'link_path' => 'required|filled',
            'article_path' => 'required|filled'
        ]);

        $input = Input::all();

        foreach ($input as $key => $value){
            $input[$key] = str_replace("@", "#", $value);
        }

        $result = CMS::parserDot($input['url'], $input['alias'], $input['events_path'], $input['title_path'], $input['date_path'], $input['link_path'], $input['img_path'], $input['article_path']);

        return response()->json([
            "response" => $result
        ]);
    }


    public function testPsyTribe(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|filled',
            'alias' => 'required|filled',
            'place' => 'required|filled',
            'events_path' => 'required|filled',
            'title_path' => 'required|filled',
            'date_path' => 'required|filled',
            'img_path' => 'required|filled',
            'link_path' => 'required|filled',
            'article_path' => 'required|filled'
        ]);

        $input = Input::all();

        foreach ($input as $key => $value){
            $input[$key] = str_replace("@", "#", $value);
        }
        $result = CMS::parserPsytribe($input['url'], $input['alias'], $input['events_path'], $input['title_path'], $input['date_path'], $input['link_path'], $input['img_path'], $input['article_path']);

        return response()->json([
            "response" => $result
        ]);

    }

    public function testGribych(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|filled',
            'alias' => 'required|filled',
            'place' => 'required|filled',
            'events_path' => 'required|filled',
            'title_path' => 'required|filled',
            'date_path' => 'required|filled',
            'img_path' => 'required|filled',
            'link_path' => 'required|filled',
            'article_path' => 'required|filled'
        ]);

        $input = Input::all();

        foreach ($input as $key => $value){
            $input[$key] = str_replace("@", "#", $value);
        }

        $result = CMS::parserGribych($input['url'], $input['alias'], $input['events_path'], $input['title_path'], $input['date_path'], $input['link_path'], $input['img_path'], $input['article_path']);

        return response()->json([
            "response" => $result
        ]);

    }




    public function testTest(Request $request)
    {
        CMS::parserTest();
    }

}