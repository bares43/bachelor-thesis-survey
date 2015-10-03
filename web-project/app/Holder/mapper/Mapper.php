<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 9. 2015
 * Time: 20:11
 */

namespace App\Holder\Mapper;


use App\Holder\Holder;

interface Mapper {

    /**
     * @param $result
     * @return Holder
     */
    public function populate($result);
}