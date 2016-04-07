<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:09
 */
namespace App\Database;

use App\Base\Database;
use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Wireframe extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Wireframe::getClassName());
    }

    /**
     * @return Model\Wireframe[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Wireframe|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Wireframe $wireframe
     */
    public function save(Model\Wireframe $wireframe)
    {
        $this->_save($wireframe);
    }

}