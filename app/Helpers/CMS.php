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

    public static function dateFormat($string)
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
}