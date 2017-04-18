<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Models\ParserConfig;


class ParserController extends Controller
{

    public function index()
    {
        return view('admin.parser');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|filled',
            'alias' => 'required|filled',
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


    public function parse()
    {

        $result = CMS::parse('http://www.dottm.ru/event/', 'dot', '#events-list li', '#events-list h2 a', '.post-meta', '#events-list a.more1', 'article img', 'article p');


        $html = new \Htmldom('http://www.dottm.ru/event/');
        $dir = public_path().config('conf.dirs.parser.dot');
        $result = [];

        $event = $html->find('#events-list li');

        foreach ($event as $key => $val){

            foreach($html->find('#events-list h2 a') as $title){
                $result[$key]['title'] = $title->plaintext;
            }
            foreach($html->find('.post-meta') as $date){
                $date_int = preg_replace('/[^0-9]/', '', $date->plaintext);
                $date_text = preg_replace('/[^a-zа-я\s]/ui', '', $date->plaintext);
                $new_date =  $date_int." ".trim($date_text)." ".date("Y");
                $result[$key]['date'] = CMS::dateFormat($new_date);
            }
            foreach($html->find('#events-list a.more1') as $link){
                $result[$key]['link'] = $link->href;
                $new_html =  new \Htmldom($link->href);

                $article = '';
                foreach($new_html->find('article p') as $text){
                    if (stripos($text, "<img") == false){
                        $article .= $text;
                    };
                }
                $result[$key]['article'] = $article;

                foreach($new_html->find('article img') as $img){
                    $split = explode(".", $img->src);
                    $split = array_reverse($split);
                    $ext = $split[0];
                    $name = rtrim(strtr(base64_encode($img->src), '+/', '-_'), '=');
                    $name = substr($name, 0, 15);
                    $file = $dir.time()."_".$name.".".$ext;
                    $result[$key]['image'] = config('conf.dirs.parser.dot').time()."_".$name.".".$ext;
                    $image = file_get_contents($img->src);
                    file_put_contents($file, $image);
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

    public function test(Request $request)
    {

        $this->validate($request, [
            'url' => 'required|filled',
            'alias' => 'required|filled',
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

        $result = CMS::parse($input['url'], $input['alias'], $input['events_path'], $input['title_path'], $input['date_path'], $input['link_path'], $input['img_path'], $input['article_path']);

        return response()->json([
            "response" => $result
        ]);
    }

}