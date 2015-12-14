<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 14. 12. 2015
 * Time: 2:04
 */

namespace App\Database;


use App\Base\Database;
use Kdyby\Doctrine\EntityManager;

class User extends Database{

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, \App\Model\User::getClassName());
    }

    /**
     * @param String $login
     * @return \App\Model\User
     */
    public function getByLogin($login) {
        $result = $this->_getBy(array('login'=>$login),null,1);
        if(count($result) === 1) return $result[0];
        return null;
    }
}