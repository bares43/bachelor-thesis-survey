<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 9. 2015
 * Time: 20:11
 */

namespace App\Base;


interface IMapper {

    /**
     * @param $result
     * @return IHolder
     */
    public function populate($result);
}