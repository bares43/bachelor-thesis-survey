<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:07
 */
namespace App\Service;

use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Respondents extends BaseService {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Respondent::class);
    }

    /**
     * @return Model\Respondent[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $age
     * @return Model\Respondent[]
     */
    public function getAllByAge($age = 20)
    {
        return $this->entityManager->getRepository($this->repositoryName)->findBy(array("age"=>$age));
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