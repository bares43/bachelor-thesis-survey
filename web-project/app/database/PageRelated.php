<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 28. 9. 2015
 * Time: 14:27
 */

namespace App\Database;


use App\Base\Database;
use App\Base\Service;
use Kdyby\Doctrine\EntityManager;

class PageRelated extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, \App\Model\PageRelated::getClassName());
    }

    /**
     * @param $id_page
     * @return \App\Model\PageRelated[]
     */
    public function getPageRelated($id_page) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("page_related");
        $query->from(\App\Model\PageRelated::getClassName(),"page_related");
        $query->where($query->expr()->eq("page_related.id_page_a",$id_page));
        $query->orWhere($query->expr()->eq("page_related.id_page_b",$id_page));

        $rows = $query->getQuery()->getResult();

        $related = array();
        foreach($rows as $row){
            $related[] = Service::populateEntity($row,\App\Model\PageRelated::getClassName(),null);
        }
        return $related;
    }
}