<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 14. 12. 2015
 * Time: 2:06
 */

namespace App\Service;


use App\Base\Service;

class User extends Service{

    /** @var \App\Database\User */
    private $database;

    /**
     * User constructor.
     * @param \App\Database\User $database
     */
    public function __construct(\App\Database\User $database) {
        $this->database = $database;
    }

    /**
     * @param string $login
     * @return \App\Model\User
     */
    public function getByLogin($login) {
        return $this->database->getByLogin($login);
    }
}