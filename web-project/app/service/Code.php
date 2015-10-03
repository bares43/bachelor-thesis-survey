<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 3. 10. 2015
 * Time: 15:57
 */

namespace App\Service;


use App\Base\Service;

class Code extends Service {

    /** @var \App\Database\Code */
    private $database;

    /**
     * Code constructor.
     * @param \App\Database\Code $database
     */
    public function __construct(\App\Database\Code $database) {
        $this->database = $database;
    }

    /**
     * @param string $url
     * @return \App\Model\Code
     */
    public function getByUrl($url) {
        return $this->database->getByUrl($url);
    }

}