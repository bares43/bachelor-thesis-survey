<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:29
 */

namespace App\Service;


use App\Base\Service;

class Website extends Service {

    /** @var \App\Database\Website */
    private $database;

    /**
     * Website constructor.
     * @param \App\Database\Website $db_website
     */
    public function __construct(\App\Database\Website $db_website) {
        $this->database = $db_website;
    }

    /**
     * @param $id_website
     * @return \App\Model\Website|null
     */
    public function get($id_website) {
        return $this->database->get($id_website);
    }

    /**
     * @return \App\Model\Website[]
     */
    public function getAll() {
        return $this->database->getAll();
    }

    /**
     * @param \App\Model\Website $website
     */
    public function save($website) {
        $this->database->save($website);
    }

    /**
     * @param \App\Filter\Results\Websites $filter
     * @return \App\Holder\Results\Base\Website
     */
    public function getResultsWebsites($filter = null) {
        return $this->database->getResultsWebsites($filter);
    }



}