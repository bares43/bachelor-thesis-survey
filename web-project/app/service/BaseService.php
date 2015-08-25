<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 16:51
 */

namespace App\Service;

use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Doctrine\EntityManager;
use Nette;

class BaseService extends Nette\Object {

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
}