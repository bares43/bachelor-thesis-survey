<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:42
 */

namespace App\Base;

use Kdyby\Doctrine\Entities\BaseEntity;

class Service {
    /**
     * @param $row
     * @param string $entityName
     * @param string $alias
     * @return BaseEntity
     */
    public static function populateEntity($row, $entityName, $alias) {
        $entity = new $entityName;

        foreach ($row as $column => $value) {
            if (preg_match('/^' . $alias . '_(.*)/', $column, $match)) {
                $columnName = $match[1];
                $entity->$columnName = $value;
            }
        }

        return $entity;
    }
}