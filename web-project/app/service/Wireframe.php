<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:34
 */

namespace App\Service;


use App\Base\Service;

class Wireframe extends Service {

    /** @var \App\Database\Wireframe */
    private $database;

    /**
     * Wireframe constructor.
     * @param \App\Database\Wireframe $db_wireframe
     */
    public function __construct(\App\Database\Wireframe $db_wireframe) {
        $this->database = $db_wireframe;
    }

    /**
     * @param $id_wireframe
     * @return \App\Model\Wireframe|null
     */
    public function get($id_wireframe) {
        return $this->database->get($id_wireframe);
    }

    /**
     * @return \App\Model\Wireframe[]
     */
    public function getAll() {
        return $this->database->getAll();
    }

    /**
     * @param \App\Model\Wireframe $wireframe
     */
    public function save($wireframe) {
        $this->database->save($wireframe);
    }
}