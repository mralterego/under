<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Cache;


class CMS
{
    public static function translitMonth($string) {
        $converter = array(
            'янв' => 'jan',     'январь' => 'january',      'января' => 'january',
            'фев' => 'feb',     'февраль' => 'february',    'февраля' => 'february',
            'мар' => 'mar',     'март' => 'march',          'марта' => 'march',
            'апр' => 'apr',     'апрель' => 'april',        'апреля' => 'april',
            'май' => 'may',     'июнь' => 'june',           'июня' => 'june',
            'июн' => 'jun',     'июль' => 'july',           'июля' => 'july',
            'июл' => 'jul',     'август' => 'august',       'августa' => 'august',
            'авг' => 'aug',     'сентябрь' => 'september',  'сентября' => 'september',
            'сен' => 'sep',     'октябрь' => 'october',     'октября' => 'october',
            'сент' => 'sept',   'ноябрь' => 'november',     'ноября' => 'november',
            'окт' => 'oct',     'декабрь' => 'december',    'декабря' => 'december',
            'ноя' => 'nov',                                 'мая' => 'may',
            'нбр' => 'nov',
            'дек' => 'dec',
        );
        return strtr($string, $converter);
    }

    public static function dateFormatDot($string)
    {
        $split = explode(" ", $string);

        if (count($split) == 3){
            $date = CMS::translitMonth(mb_strtolower($string));
            $date = date_create($date);
            return $date;
        } else if (count($split) == 2){
            $string = implode(" ", $split);
            $string .= " 2017";
            $date = CMS::translitMonth(mb_strtolower($string));
            $date = date_create($date);
            return $date;

        } else {
             return "bad format";
        }

    }


    public static function dateFormatPsytribe($string)
    {
        $string = strip_tags($string);
        $string = str_replace(".", "/", $string);
        if (strlen($string) < 11){
            $date = date_create($string);
            return $date;
        } else {
            $parts = explode("-", $string);
            $date = $parts[0].substr($parts[1], 2);
            $date_splited = explode("/", $date);
            $date = $date_splited[1]."/".$date_splited[0]."/".$date_splited[2];
            $date = date_create($date);
            return $date;
        }
    }

    public static function createDir($dir)
    {
        $result = false;

        if (!is_dir($dir)){
           $result = mkdir($dir, 755);
        }
        return $result;
    }

    public static function parserDot($url, $alias, $events_path, $title_path, $date_path, $link_path, $img_path, $article_path)
    {
        $html = new \Htmldom($url);
        $dir = public_path().config('conf.dirs.parser').$alias."/";
        $result = [];

        CMS::createDir($dir);

        $event = $html->find($events_path);

        foreach ($event as $key => $val){

            foreach($html->find($title_path) as $title){
                $result[$key]['title'] = $title->plaintext;
            }
            foreach($html->find($date_path) as $date){
                $date_int = preg_replace('/[^0-9]/', '', $date->plaintext);
                $date_text = preg_replace('/[^a-zа-я\s]/ui', '', $date->plaintext);
                $new_date =  $date_int." ".trim($date_text)." ".date("Y");
                $result[$key]['date'] = CMS::dateFormatDot($new_date);
            }
            foreach($html->find($link_path) as $link){

                $result[$key]['link'] = $link->href;
                $new_html =  new \Htmldom($link->href);
                $article = '';

                foreach($new_html->find($article_path) as $text){
                    if (stripos($text, "<img") == false){
                        if (stripos($text, "<iframe") == false) {
                            $article .= $text;
                        }
                    };
                }
                $result[$key]['article'] = $article;
                $result[$key]['place'] = 'DOT';
                $result[$key]['tags'] = ['techno', 'техно'];

                foreach($new_html->find($img_path) as $img){
                    $split = explode(".", $img->src);
                    $split = array_reverse($split);
                    $ext = $split[0];
                    $name = rtrim(strtr(base64_encode($img->src), '+/', '-_'), '=');
                    $name = substr($name, -20);
                    $file = $dir."_".$name.".".$ext;
                    $result[$key]['image'] = config('conf.dirs.parser').$alias."/"."_".$name.".".$ext;
                    $image = file_get_contents($img->src);
                    file_put_contents($file, $image);
                }
            }
        }
        return $result;
    }

    public static function parserPsytribe($url, $alias, $events_path, $title_path, $date_path, $link_path, $img_path, $article_path)
    {

        $html = new \Htmldom($url);
        $dir = public_path().config('conf.dirs.parser').$alias."/";

        $result = [];

        CMS::createDir($dir);


        foreach($html->find($title_path) as $key => $title){
            $split = explode('@',  $title->plaintext);
            $result[$key]['title'] = trim($split[0]);
            $result[$key]['place'] = trim($split[1]);

        }
        foreach($html->find($date_path) as $key => $date){

            $result[$key]['date'] =  CMS::dateFormatPsytribe($date);
        }

        foreach($html->find($link_path) as $key => $link){
            $result[$key]['link'] = "http://psytribe.org".$link->href;
            $new_html =  new \Htmldom("http://psytribe.org".$link->href);

            $img = $new_html->find($img_path, 0);

            $split = explode(".", $img->src);
            $split = array_reverse($split);
            $ext = $split[0];
            $name = rtrim(strtr(base64_encode($img->src), '+/', '-_'), '=');
            $name = substr($name, -20);
            $file = $dir."_".$name.".".$ext;
            $result[$key]['image'] = config('conf.dirs.parser').$alias."/"."_".$name.".".$ext;
            $image = file_get_contents($img->src);
            file_put_contents($file, $image);

            $article = "";
            foreach($new_html->find($article_path) as $text){
                if (stripos($text, "<img") == false){
                    $article .= $text;
                }
            }
            $result[$key]['article'] = $article;
            $result[$key]['tags'] = ['psy', 'psychedelic'];
        }

        return $result;
    }

    public static function parserGribych($url, $alias, $events_path, $title_path, $date_path, $link_path, $img_path, $article_path){

        $html = new \Htmldom($url);
        $dir = public_path().config('conf.dirs.parser').$alias."/";

        CMS::createDir($dir);

        $filter = ['techno','техно','trance','транс', 'Techno', 'Техно', 'TECHNO'];

        $result = [];
        $res = [];

        foreach ($html->find($events_path) as $key => $path){

            foreach ($path->find("p") as $k => $event){
                $found = false;
                $title = strip_tags($event);
                foreach($filter as $f){
                    if (strpos($title, $f) != false){
                        $found = true;
                    }
                }
                if ($found){
                    $needle = $path->find("p", $k + 1)->children(0);
                    $img = preg_replace_callback('/<img(?:\\s[^<>]*?)?\\bsrc\\s*=\\s*(?|"([^"]*)"|\'([^\']*)\'|([^<>\'"\\s]*))[^<>]*>/i',
                        function($images) use ($dir, $alias, &$k, &$res){
                            $img_dir = "http://www.griboedovclub.ru/".$images[1];
                            $split = explode(".", $images[1]);
                            $split = array_reverse($split);
                            $ext = $split[0];
                            $name = rtrim(strtr(base64_encode($images[1]), '+/', '-_'), '=');
                            $name = substr($name, -20);
                            $file = $dir."_".$name.".".$ext;
                            $res[$k]['image'] = config('conf.dirs.parser').$alias."/"."_".$name.".".$ext;
                            $image = file_get_contents($img_dir);
                            file_put_contents($file, $image);
                        }, $needle);

                    $link = preg_replace_callback('/<a(?:\\s[^<>]*?)?\\bhref\\s*=\\s*(?|"([^"]*)"|\'([^\']*)\'|([^<>\'"\\s]*))[^<>]*>/i',
                        function($links) use ($dir, $alias, &$k, &$res){
                            $res[$k]['link']  = $links[1];
                        }, $needle);

                    $title_splited = explode("&nbsp;", $title);
                    $res[$k]['title'] = $title_splited[1];
                    $res[$k]['place'] = "Модный клуб &laquo;Грибоедов&raquo;";
                    $res[$k]['article'] = "";
                    $res[$k]['tags'] = ['techno', 'техно'];

                    $date = $html->find($date_path, $key)->children(0);
                    $splited = explode(',', $date);
                    $res[$k]['date'] = CMS::dateFormatDot(trim(strip_tags($splited[0])));
                }
            }
        }

        $result = array_merge($res, []);

        return $result;

    }

    public static function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

    public static function parserTest()
    {
        $html = new \Htmldom("https://spb.ponominalu.ru/tag/dnb");
        dd($html);
        $events_path = ".event";
        $needle = $html->find($events_path, 1)->children(0);
        echo $needle;
    }


}