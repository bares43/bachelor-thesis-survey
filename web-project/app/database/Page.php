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
     * @param int[] $id_pages
     * @return \App\Holder\Page[]
     */
    public function getPageHolders($id_pages) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("page");
        $query->from(Model\Page::getClassName(),"page");

        $query->join(Model\Website::getClassName(),"website",Join::WITH,"page.id_website = website.id_website")->addSelect("website");

        if(count($id_pages) > 0){
            $query->where($query->expr()->in("page.id_page",$id_pages));
        }else{
            $query->where($query->expr()->isNull("page.id_page"));
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

        if($filter->getIdPage() !== null){
            $query->where($query->expr()->eq("page.id_page",$filter->getIdPage()));
        }

        if($filter->isRequiredColor()){
            $query->where($query->expr()->isNotNull("page.dominant_color"));
        }

        if($filter->isRequiredTextColor()){
            $query->where($query->expr()->isNotNull("page.dominant_text_color"));
        }

        if($filter->getTextMode() !== null){
            $query->where($query->expr()->eq("wireframe.text_mode",$filter->getTextMode()));
        }

        if($filter->getImageMode() !== null){
            $query->where($query->expr()->eq("wireframe.image_mode",$filter->getImageMode()));
        }

        if($filter->getUserAgent() !== null){
            $query->where($query->expr()->eq("wireframe.user_agent",$filter->getUserAgent()));
        }

        if($filter->getMinResolutionWidth() !== null){
            $query->where($query->expr()->gte("wireframe.resolution_width", $filter->getMinResolutionWidth()));
        }

        if($filter->getMinResolutionHeight() !== null){
            $query->where($query->expr()->gte("wireframe.resolution_height", $filter->getMinResolutionHeight()));
        }

        if($filter->getMaxResolutionWidth() !== null){
            $query->where($query->expr()->lte("wireframe.resolution_width", $filter->getMaxResolutionWidth()));
        }

        if($filter->getMaxResolutionHeight() !== null){
            $query->where($query->expr()->lte("wireframe.resolution_height", $filter->getMaxResolutionHeight()));
        }

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
        if(count($holders) > 0) return $holders[array_rand($holders)];
        return null;
    }
}