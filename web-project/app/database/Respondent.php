<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:07
 */
namespace App\Database;

use App\Base\Database;
use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Respondent extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Respondent::getClassName());
    }

    /**
     * @return Model\Respondent[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Respondent|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Respondent $respondent
     */
    public function save(Model\Respondent $respondent)
    {
        $this->_save($respondent);
    }
}