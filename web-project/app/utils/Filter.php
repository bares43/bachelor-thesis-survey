<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 19. 12. 2015
 * Time: 9:20
 */

namespace App\Utils;


use Nette\Utils\ArrayHash;

class Filter {

    /**
     * @param string|array $input
     * @return array
     */
    public static function createFilterArray($input) {
        if(is_array($input) || $input instanceof ArrayHash){
            $items = array();
            foreach($input as $item){
                if(is_array($item) || $item instanceof ArrayHash){
                    $items[] = current($item);
                }else{
                    $items[] = $item;
                }
            }
        }else{
            $items = explode(",",$input);
        }

        $filter = array();
        foreach($items as $item){
            if(preg_match('/([<>]?=?)(.+)/',$item, $match)){
                if($match[1]){
                    $filter[$match[1]] = $match[2];
                }else{
                    $filter[] = $match[2] === "null" ? null : $match[2];
                }
            }
        }

        return $filter;
    }
}