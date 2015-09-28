<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:29
 */

namespace App\Service;


use App\Base\Service;

class Category extends Service {

    /** @var \App\Database\Category */
    private $database;

    /**
     * Category constructor.
     * @param \App\Database\Category $database
     */
    public function __construct(\App\Database\Category $database) {
        $this->database = $database;
    }

    /**
     * @param $id_category
     * @return \App\Model\Category|null
     */
    public function get($id_category) {
        return $this->database->get($id_category);
    }

    /**
     * @return \App\Model\Category[]
     */
    public function getAll() {
        return $this->database->getAll();
    }

    /**
     * @param \App\Model\Category $category
     */
    public function save($category) {
        $this->database->save($category);
    }

}