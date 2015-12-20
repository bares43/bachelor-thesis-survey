<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 22:23
 */

namespace App\Utils;


class Base {

    /**
     * @param float $seconds
     * @return string
     */
    public static function getSecondsToString($seconds) {
        $seconds = round($seconds);
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes = floor($seconds/60);
        $seconds -= $minutes*60;

        $res = "";
        $res .= $hours > 0 ? $hours."h " : "";
        $res .= $minutes > 0 ? $minutes."m " : "";
        $res .= ($seconds > 0 || $res === "") ? $seconds."s" : "";

        return $res;
    }

    /**
     * @param bool|null $bool
     * @return string
     */
    public static function getBooleanToString($bool) {
        if($bool){
            return "ano";
        }elseif($bool !== null){
            return "ne";
        }else{
            return "";
        }
    }


}