<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 20:48
 */

namespace App\Base;


class Filter {

    const LIMIT = "limit";

    const GROUP_BY = "groupby";

    const ORDER_BY = "orderby";

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

    /**
     * @param int $limit
     */
    public function setLimit($limit) {
        $this->set(self::LIMIT,$limit);
    }

    /**
     * @return int
     */
    public function getLimit() {
        return $this->get(self::LIMIT);
    }

    /**
     * @param bool $group
     */
    public function setGroupBy($group) {
        $this->set(self::GROUP_BY, $group);
    }

    /**
     * @return bool
     */
    public function getGroupBy() {
        return $this->get(self::GROUP_BY);
    }

    /**
     * @param array $order_by
     */
    public function setOrderBy($order_by) {
        $this->set(self::ORDER_BY, $order_by);
    }

    /**
     * @return array
     */
    public function getOrderBy() {
        return $this->get(self::ORDER_BY);
    }
}