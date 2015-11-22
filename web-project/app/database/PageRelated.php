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
use Doctrine\ORM\Query\Expr\Join;
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
     * @param \App\Filter\PageRelated $filter
     * @return \App\Holder\PageRelated[]
     */
    public function getRelatedPagesByFilter(\App\Filter\PageRelated $filter) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("page_related");
        $query->from(\App\Model\PageRelated::getClassName(),"page_related");
        $query->join(\App\Model\Page::getClassName(),"page_a",Join::WITH,"page_related.id_page_a = page_a.id_page")->addSelect("page_a");
        $query->join(\App\Model\Page::getClassName(),"page_b",Join::WITH,"page_related.id_page_b = page_b.id_page")->addSelect("page_b");
        $query->join(\App\Model\Website::getClassName(),"website_a",Join::WITH,"page_a.id_website = website_a.id_website")->addSelect("website_a");
        $query->join(\App\Model\Website::getClassName(),"website_b",Join::WITH,"page_b.id_website = website_b.id_website")->addSelect("website_b");
        $query->join(\App\Model\Wireframe::getClassName(),"wireframe_a",Join::WITH,"page_a.id_page = wireframe_a.id_page")->addSelect("wireframe_a");
        $query->join(\App\Model\Wireframe::getClassName(),"wireframe_b",Join::WITH,"page_b.id_page = wireframe_b.id_page")->addSelect("wireframe_b");

        if($filter->getIdsPage() !== null && count($filter->getIdsPage()) > 0){
            $query->andWhere($query->expr()->in("page_a.id_page",$filter->getIdsPage()));
            $query->orWhere($query->expr()->in("page_b.id_page",$filter->getIdsPage()));
        }

        if($filter->isDuel()){
            $query->andWhere($query->expr()->eq("page_related.duel",1));
        }

        if($filter->getIdsPageRelated() !== null && count($filter->getIdsPageRelated()) > 0){
            $query->andWhere($query->expr()->in("page_related.id_page_related",$filter->getIdsPageRelated()));
        }

        if($filter->getIdPage() !== null){
            $query->andWhere($query->expr()->eq("page_a.id_page",$filter->getIdPage()));
            $query->andWhere($query->expr()->eq("page_b.id_page",$filter->getIdPage()));
        }

        if($filter->isRequiredColor()){
            $query->andWhere($query->expr()->isNotNull("page_a.dominant_color"));
            $query->andWhere($query->expr()->isNotNull("page_b.dominant_color"));
        }

        if($filter->isRequiredTextColor()){
            $query->andWhere($query->expr()->isNotNull("page_a.dominant_text_color"));
            $query->andWhere($query->expr()->isNotNull("page_b.dominant_text_color"));
        }

        if($filter->getTextMode() !== null){
            $query->andWhere($query->expr()->eq("wireframe_a.text_mode",$filter->getTextMode()));
            $query->andWhere($query->expr()->eq("wireframe_b.text_mode",$filter->getTextMode()));
        }

        if($filter->getImageMode() !== null){
            $query->andWhere($query->expr()->eq("wireframe_a.image_mode",$filter->getImageMode()));
            $query->andWhere($query->expr()->eq("wireframe_b.image_mode",$filter->getImageMode()));
        }

        if($filter->getDevices() !== null && count($filter->getDevices()) > 0){
            $query->andWhere($query->expr()->in("wireframe_a.device",$filter->getDevices()));
            $query->andWhere($query->expr()->in("wireframe_b.device",$filter->getDevices()));
        }

        if($filter->getMinResolutionWidth() !== null){
            $query->andWhere($query->expr()->gte("wireframe_a.resolution_width", $filter->getMinResolutionWidth()));
            $query->andWhere($query->expr()->gte("wireframe_b.resolution_width", $filter->getMinResolutionWidth()));
        }

        if($filter->getMinResolutionHeight() !== null){
            $query->andWhere($query->expr()->gte("wireframe_a.resolution_height", $filter->getMinResolutionHeight()));
            $query->andWhere($query->expr()->gte("wireframe_b.resolution_height", $filter->getMinResolutionHeight()));
        }

        if($filter->getMaxResolutionWidth() !== null){
            $query->andWhere($query->expr()->lte("wireframe_a.resolution_width", $filter->getMaxResolutionWidth()));
            $query->andWhere($query->expr()->lte("wireframe_b.resolution_width", $filter->getMaxResolutionWidth()));
        }

        if($filter->getMaxResolutionHeight() !== null){
            $query->andWhere($query->expr()->lte("wireframe_a.resolution_height", $filter->getMaxResolutionHeight()));
            $query->andWhere($query->expr()->lte("wireframe_b.resolution_height", $filter->getMaxResolutionHeight()));
        }

        if($filter->getLanguages() !== null && count($filter->getLanguages()) > 0){
            $query->andWhere($query->expr()->in("website_a.language",$filter->getLanguages()));
            $query->andWhere($query->expr()->in("website_b.language",$filter->getLanguages()));
        }

        if($filter->isPriority() !== null){
            $query->andWhere($query->expr()->eq("page_a.priority",$filter->isPriority()?1:0));
            $query->andWhere($query->expr()->eq("page_b.priority",$filter->isPriority()?1:0));
        }

        if($filter->getExcludeIdPage() !== null && count($filter->getExcludeIdPage()) > 0){
            $query->andWhere($query->expr()->notIn("page_a.id_page",$filter->getExcludeIdPage()));
            $query->andWhere($query->expr()->notIn("page_b.id_page",$filter->getExcludeIdPage()));
        }

        if($filter->getExcludeIdWireframe() !== null && count($filter->getExcludeIdWireframe()) > 0){
            $query->andWhere($query->expr()->notIn("wireframe_a.id_wireframe",$filter->getExcludeIdWireframe()));
            $query->andWhere($query->expr()->notIn("wireframe_b.id_wireframe",$filter->getExcludeIdWireframe()));
        }

        if($filter->getCategories() !== null && count($filter->getCategories()) > 0){
            $query->join(\App\Model\EntityCategory::getClassName(),"entity_category_a",Join::WITH,"website_a.id_website = entity_category_a.id_website");
            $query->join(\App\Model\EntityCategory::getClassName(),"entity_category_b",Join::WITH,"website_b.id_website = entity_category_b.id_website");
            $query->andWhere($query->expr()->in("entity_category_a.id_category",$filter->getCategories()));
            $query->andWhere($query->expr()->in("entity_category_b.id_category",$filter->getCategories()));
        }

        if($filter->isWebsiteVisible()){
            $query->andWhere($query->expr()->eq("website_a.visible",1));
            $query->andWhere($query->expr()->eq("website_b.visible",1));
        }

        if($filter->isPageVisible()){
            $query->andWhere($query->expr()->eq("page_a.visible",1));
            $query->andWhere($query->expr()->eq("page_b.visible",1));
        }

        if($filter->isWireframeVisible()){
            $query->andWhere($query->expr()->eq("wireframe_a.visible",1));
            $query->andWhere($query->expr()->eq("wireframe_b.visible",1));
        }

        if($filter->getLimit() !== null && $filter->getLimit() > 0){
            $query->setMaxResults($filter->getLimit());
        }

        if($filter->getGroupBy()){
            $query->groupBy("page_related.id_page_related");
        }

        return $this->getHolders($query, new \App\Holder\Mapper\PageRelated());
    }
}