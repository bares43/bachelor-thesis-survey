<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 20:48
 */

namespace App\Base;


class Filter {

    private $params = array();

    /**
     * Filter constructor.
     * @param array $params
     */
    public function __construct(array $params = null) {
        if(is_array($params)){
            foreach($params as $key=>$value){
                $setter = "set$key";
                $this->$setter($value);
            }
        }
    }

    /**
     * @param string $param
     * @param mixed $value
     */
    protected function set($param,$value){
        $this->params[$param] = $value;
    }

    /**
     * @param string $param
     * @return mixed
     */
    protected function get($param){
        if(array_key_exists($param,$this->params)) return $this->params[$param];
        return null;
    }


}