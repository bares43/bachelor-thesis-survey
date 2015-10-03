<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:08
 */
namespace App\Database;

use App\Base\Database;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Subquestion extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Subquestion::getClassName());
    }

    /**
     * @return Model\Subquestion[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Subquestion|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param int[] $ids_question
     * @return Model\Subquestion[]
     */
    public function getByIdsQuestion($ids_question) {
        $criteria = array();
        if(count($ids_question) > 0){
            $criteria["id_question in"] = $ids_question;
        }else{
            $criteria["id_question is"] = null;
        }
        return $this->entityManager->getRepository($this->repositoryName)->findBy($criteria);
    }


    /**
     * @param Model\Subquestion $subquestion
     */
    public function save(Model\Subquestion $subquestion)
    {
        if($subquestion->datetime === null) $subquestion->datetime = new \DateTime();
        $this->_save($subquestion);
    }

}
