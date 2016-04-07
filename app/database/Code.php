<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 3. 10. 2015
 * Time: 15:57
 */

namespace App\Database;


use App\Base\Database;
use Kdyby\Doctrine\EntityManager;

class Code extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, \App\Model\Code::getClassName());
    }

    /**
     * @param string $url
     * @return \App\Model\Code
     */
    public function getByUrl($url) {
        $code = $this->_getBy(array("url"=>$url));
        if(count($code)) return $code[0];
        return null;
    }
}