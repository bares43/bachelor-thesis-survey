<?php

/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 15:14
 */

namespace App\Database;

use App\Base\Database;
use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Website extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Website::getClassName());
    }

    /**
     * @return Model\Website[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Website|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Website $website
     */
    public function save(Model\Website $website)
    {
        $this->_save($website);
    }
}