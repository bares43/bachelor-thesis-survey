<?php

/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 15:14
 */

namespace App\Service;

use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Websites extends BaseService {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Website::class);
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