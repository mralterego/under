<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\CMS;
use App\Http\Requests;


class ParserController extends Controller
{

    public function index()
    {
        return view('admin.parser');
    }

    public function parse()
    {

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

        dd($result);
    }
}