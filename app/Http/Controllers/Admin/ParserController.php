<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\ParserConfig;
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
        $parsers = ParserConfig::get();

        return response() -> json($parsers);
    }

    public function create(Request $request)
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

        $parser_dir = public_path().config('conf.dirs.parser').$input['alias'];

        if (!is_dir($parser_dir)){
            mkdir($parser_dir, 0755, true);
        }

        # сохраняем конфиг парсера в бд
        $output = ParserConfig::insert(
            [
                'url' => $input['url'],
                'alias' => $input['alias'],
                'place' => $input['place'],
                'events_path' => $input['events_path'],
                'title_path' => $input['title_path'],
                'date_path' => $input['date_path'],
                'img_path' => $input['img_path'],
                'link_path' => $input['link_path'],
                'article_path' => $input['article_path'],
                'isActive' => true
            ]
        );

        # если сохранение успешно output = true, иначе false
        return response()->json([
            "response" => $output
        ]);

    }


    public function parseAndSave()
    {

        $today = Carbon::today();
        $titles = Event::pluck('title')->toArray();
        $events = [];

        $cfgPsytribe = ParserConfig::where('alias', 'psytribe')->get();
        $cfgDot = ParserConfig::where('alias', 'dot')->get();
        $cfgGribych = ParserConfig::where('alias', 'gribych')->get();

        $eventsPsytribe = CMS::parserPsytribe($cfgPsytribe[0]->url,$cfgPsytribe[0]->alias, $cfgPsytribe[0]->events_path, $cfgPsytribe[0]->title_path, $cfgPsytribe[0]->date_path, $cfgPsytribe[0]->link_path, $cfgPsytribe[0]->img_path, $cfgPsytribe[0]->article_path);
        $eventsDot = CMS::parserDot($cfgDot[0]->url,$cfgDot[0]->alias, $cfgDot[0]->events_path, $cfgDot[0]->title_path, $cfgDot[0]->date_path, $cfgDot[0]->link_path, $cfgDot[0]->img_path, $cfgDot[0]->article_path);
        $eventsGribych = CMS::parserGribych($cfgGribych[0]->url,$cfgGribych[0]->alias, $cfgGribych[0]->events_path, $cfgGribych[0]->title_path, $cfgGribych[0]->date_path, $cfgGribych[0]->link_path, $cfgGribych[0]->img_path, $cfgGribych[0]->article_path);

        # объединяем массивы с событиями
        $events = array_merge($eventsPsytribe, $eventsDot, $eventsGribych);

        if (!empty($events)){
            foreach ($events as $k => $event){
                # если дата с будущем и нет таких записей заголовокоа прежде
                if ($event['date'] > $today AND !in_array($event['title'], $titles)){
                    # формируем событие и сохраняем
                    $item = [
                        'title' => $event['title'],
                        'content' => $event['article'],
                        'image' => $event['image'],
                        'author' => 'parser',
                        'price' => 'none',
                        'link' => $event['link'],
                        'place' => $event['place'],
                        'date' => $event['date']
                    ];
                    Event::create($item);
                }
            }
        }


    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|filled',
            'events_path' => 'required|filled',
            'title_path' => 'required|filled',
            'date_path' => 'required|filled',
            'img_path' => 'required|filled',
            'link_path' => 'required|filled',
            'article_path' => 'required|filled'
        ]);
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