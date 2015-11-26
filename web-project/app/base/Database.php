<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 16:51
 */

namespace App\Base;

use Doctrine\ORM\AbstractQuery;
use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\QueryBuilder;
use Nette;

class Database extends Nette\Object {

    /** @var EntityManager $entityManager */
    protected $entityManager;

    /** @var  string $repositoryName */
    protected $repositoryName;

    /**
     * @param EntityManager $entityManager
     * @param string $repositoryName
     */
    public function __construct(EntityManager $entityManager, $repositoryName)
    {
        $entityManager->getConfiguration()->addCustomNumericFunction("greatest",'App\Doctrine\Greatest');
        $entityManager->getConfiguration()->addCustomNumericFunction("least",'App\Doctrine\Least');
        $entityManager->getConfiguration()->addCustomNumericFunction("rand",'App\Doctrine\Rand');
        $this->entityManager = $entityManager;
        $this->repositoryName = $repositoryName;
    }

    /**
     * @return BaseEntity[]
     */
    protected function _getAll()
    {
        return $this->entityManager->getRepository($this->repositoryName)->findAll();
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return \Kdyby\Doctrine\Entities\BaseEntity[]
     */
    protected function _getBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->entityManager->getRepository($this->repositoryName)->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param int $id
     * @return null|BaseEntity
     */
    protected function _get($id)
    {
        return $this->entityManager->getRepository($this->repositoryName)->find($id);
    }

    /**
     * @param BaseEntity $entity
     */
    protected function _save(BaseEntity $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param QueryBuilder $query
     * @param IMapper $mapper
     * @return IMapper[]
     */
    protected function populateMapper($query, $mapper){
        $rows = $query->getQuery()->getResult(AbstractQuery::HYDRATE_SCALAR);
        $result = array();
        foreach($rows as $row){
            $result[] = $mapper->populate($row);
        }
        return $result;
    }

    /**
     * @param QueryBuilder $query
     * @param IMapper $mapper
     * @return IHolder
     */
    public function getHolder($query, $mapper) {
        $holders = $this->getHolders($query, $mapper);
        if(count($holders) === 1){
            return $holders[0];
        }else{
            return null;
        }
    }

    /**
     * @param QueryBuilder $query
     * @param IMapper $mapper
     * @return IHolder[]
     */
    public function getHolders($query, $mapper) {
        return $this->populateMapper($query, $mapper);
    }


}