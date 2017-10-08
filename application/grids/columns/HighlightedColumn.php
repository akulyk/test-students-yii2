<?php

namespace  application\grids\columns;

use yii\grid\DataColumn;


class HighlightedColumn extends DataColumn
{
    public static function highlight($string,$query){
        if(!$query){
            return $string;
        }
        $input = mb_strtolower($query);
        $newString = mb_strtolower($string);
        if (strpos($newString,$input) !== false ){
            $html = preg_replace("#($input)#i",
                "<span class='highlighted'>$1</span>",$string);
        } else{
            $html = $string;
        }

        return $html;

    }

}