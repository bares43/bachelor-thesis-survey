<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:06
 */
namespace App\Database;

use App\Base\Database;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Page extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Page::getClassName());
    }

    /**
     * @return Model\Page[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Page|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Page $page
     */
    public function save(Model\Page $page)
    {
        $this->_save($page);
    }

    /**
     * @param \App\Filter\Page $filter
     * @return \App\Holder\Page[]
     */
    public function getPageHoldersByFilter(\App\Filter\Page $filter) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("page");
        $query->from(Model\Page::getClassName(),"page");

        $query->join(Model\Website::getClassName(),"website",Join::WITH,"page.id_website = website.id_website")->addSelect("website");

        if($filter->getLanguages() !== null && count($filter->getLanguages()) > 0){
            $query->where($query->expr()->in("website.language",$filter->getLanguages()));
        }

        $mapper = new \App\Holder\Mapper\Page();

        return $this->getHolders($query, $mapper);
    }

    /**
     * @param \App\Filter\Page $filter
     * @return \App\Holder\Page
     */
    public function getPageHolderByFilter(\App\Filter\Page $filter) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("page");
        $query->from(Model\Page::getClassName(),"page");

        $query->join(Model\Website::getClassName(),"website",Join::WITH,"page.id_website = website.id_website")->addSelect("website");
        $query->join(Model\Wireframe::getClassName(),"wireframe",Join::WITH,"page.id_page = wireframe.id_page")->addSelect("wireframe");

        if($filter->getLanguages() !== null && count($filter->getLanguages()) > 0){
            $query->where($query->expr()->in("website.language",$filter->getLanguages()));
        }

        if($filter->isPriority() !== null){
            $query->where($query->expr()->eq("page.priority",$filter->isPriority()?1:0));
        }

        if($filter->getExcludeIdPage() !== null && count($filter->getExcludeIdPage()) > 0){
            $query->where($query->expr()->notIn("page.id_page",$filter->getExcludeIdPage()));
        }

        $mapper = new \App\Holder\Mapper\Page();

//        $query->setMaxResults(1);
//        $query->orderBy("random");


        $holders = $this->getHolders($query, $mapper);
        return $holders[array_rand($holders)];
    }
}