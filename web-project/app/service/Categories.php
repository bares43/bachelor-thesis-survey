<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 16:05
 */

namespace App\Service;

use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Categories extends BaseService {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Category::class);
    }

    /**
     * @return Model\Category[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Category|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Category $category
     */
    public function save(Model\Category $category)
    {
        $this->_save($category);
    }
}