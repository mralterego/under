<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\ParserConfig;
use App\Models\Event;


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

        $cfgPsytribe = ParserConfig::where('alias', 'psytribe')->get();

        $eventsPsytribe = CMS::parserPsytribe($cfgPsytribe->url,$cfgPsytribe->alias, $cfgPsytribe->events_path, $cfgPsytribe->title_path, $cfgPsytribe->date_path, $cfgPsytribe->link_path, $cfgPsytribe->img_path, $cfgPsytribe->article_path);

        

        $cfgDot = ParserConfig::where('alias', 'dot')->get();

        $eventsDot = CMS::parserDot($cfgDot->url,$cfgDot->alias, $cfgDot->events_path, $cfgDot->title_path, $cfgDot->date_path, $cfgDot->link_path, $cfgDot->img_path, $cfgDot->article_path);



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

}