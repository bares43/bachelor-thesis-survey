<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 19. 12. 2015
 * Time: 9:16
 */

namespace App\Utils;


class Arr {

    /**
     * @param array $array
     * @return bool
     */
    public static function is_assoc(array $array) {
        $keys = array_keys($array);
        return array_keys($keys) !== $keys;
    }
}