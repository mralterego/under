<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Cache;


class CMS
{
    public static function translitMonth($string) {
        $converter = array(
            'янв' => 'jan',     'январь' => 'january',
            'фев' => 'feb',     'февраль' => 'february',
            'мар' => 'mar',     'март' => 'march',
            'апр' => 'apr',     'апрель' => 'april',
            'май' => 'may',     'июнь' => 'june',
            'июн' => 'jun',     'июль' => 'july',
            'июл' => 'jul',     'август' => 'august',
            'авг' => 'aug',     'сентябрь' => 'september',
            'сен' => 'sep',     'октябрь' => 'october',
            'сент' => 'sept',   'ноябрь' => 'november',
            'окт' => 'oct',     'декабрь' => 'december',
            'ноя' => 'nov',
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

    public static function parserDot($url, $alias, $events_path, $title_path, $date_path, $link_path, $img_path, $article_path)
    {
        $html = new \Htmldom($url);
        $dir = public_path().config('conf.dirs.parser').$alias."/";
        $result = [];

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

                foreach($new_html->find($img_path) as $img){
                    $split = explode(".", $img->src);
                    $split = array_reverse($split);
                    $ext = $split[0];
                    $name = rtrim(strtr(base64_encode($img->src), '+/', '-_'), '=');
                    $name = substr($name, 0, 15);
                    $file = $dir.time()."_".$name.".".$ext;
                    $result[$key]['image'] = config('conf.dirs.parser').$alias."/".time()."_".$name.".".$ext;
                    $image = file_get_contents($img->src);
                    file_put_contents($file, $image);
                }
            }
        }
        return $result;
    }



}