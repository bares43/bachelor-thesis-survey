<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:06
 */
namespace App\Database;

use App\Base\Database;
use App\Holder\Mapper\ResultsPage;
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
        $query->addSelect("rand() as rand");
        $query->from(Model\Page::getClassName(),"page");

        $query->join(Model\Website::getClassName(),"website",Join::WITH,"page.id_website = website.id_website")->addSelect("website");
        $query->join(Model\Wireframe::getClassName(),"wireframe",Join::WITH,"page.id_page = wireframe.id_page")->addSelect("wireframe");

        if($filter->getIdPage() !== null){
            $query->andWhere($query->expr()->eq("page.id_page",$filter->getIdPage()));
        }

        if($filter->isRequiredColor()){
            $query->andWhere($query->expr()->isNotNull("page.dominant_color"));
            $query->andWhere($query->expr()->gt($query->expr()->length($query->expr()->trim("page.dominant_color")),0));
        }

        if($filter->isRequiredTextColor()){
            $query->andWhere($query->expr()->isNotNull("page.dominant_text_color"));
            $query->andWhere($query->expr()->gt($query->expr()->length($query->expr()->trim("page.dominant_text_color")),0));
        }

        if($filter->getTextMode() !== null){
            $query->andWhere($query->expr()->eq("wireframe.text_mode","'".$filter->getTextMode()."'"));
        }

        if($filter->getImageMode() !== null){
            $query->andWhere($query->expr()->eq("wireframe.image_mode","'".$filter->getImageMode()."'"));
        }

        if($filter->getDevices() !== null && count($filter->getDevices()) > 0){
            $query->andWhere($query->expr()->in("wireframe.device",$filter->getDevices()));
        }

        if($filter->getMinResolutionWidth() !== null){
            $query->andWhere($query->expr()->gte("wireframe.resolution_width", $filter->getMinResolutionWidth()));
        }

        if($filter->getMinResolutionHeight() !== null){
            $query->andWhere($query->expr()->gte("wireframe.resolution_height", $filter->getMinResolutionHeight()));
        }

        if($filter->getMaxResolutionWidth() !== null){
            $query->andWhere($query->expr()->lte("wireframe.resolution_width", $filter->getMaxResolutionWidth()));
        }

        if($filter->getMaxResolutionHeight() !== null){
            $query->andWhere($query->expr()->lte("wireframe.resolution_height", $filter->getMaxResolutionHeight()));
        }

        if($filter->getLanguages() !== null && count($filter->getLanguages()) > 0){
            $query->andWhere($query->expr()->in("website.language",$filter->getLanguages()));
        }

        if($filter->isPriority() !== null && $filter->isPriority()){
            $query->andWhere($query->expr()->eq("page.priority",$filter->isPriority()?1:0));
        }

        if($filter->getExcludeIdPage() !== null && count($filter->getExcludeIdPage()) > 0){
            $query->andWhere($query->expr()->notIn("page.id_page",$filter->getExcludeIdPage()));
        }

        if($filter->getExcludeIdWireframe() !== null && count($filter->getExcludeIdWireframe()) > 0){
            $query->andWhere($query->expr()->notIn("wireframe.id_wireframe",$filter->getExcludeIdWireframe()));
        }

        if($filter->getCategories() !== null && count($filter->getCategories()) > 0){
            $query->join(Model\EntityCategory::getClassName(),"entity_category",Join::WITH,"website.id_website = entity_category.id_website");
            $query->andWhere($query->expr()->in("entity_category.id_category",$filter->getCategories()));
        }

        if($filter->isWebsiteVisible()){
            $query->andWhere($query->expr()->eq("website.visible",1));
        }

        if($filter->isPageVisible()){
            $query->andWhere($query->expr()->eq("page.visible",1));
        }

        if($filter->isWireframeVisible()){
            $query->andWhere($query->expr()->eq("wireframe.visible",1));
        }

        $query->orderBy("rand");
        $query->setMaxResults(1);

        $mapper = new \App\Holder\Mapper\Page();

        return $this->getHolder($query, $mapper);
    }

    /**
     * @param \App\Filter\Results\Pages $filter
     * @return \App\Holder\Results\Base\Page
     */
    public function getResultsPages($filter) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("page");
        $query->addSelect("count(distinct subquestion.id_subquestion) as total_subquestions");
        $query->addSelect("countif('correct','=','1') as total_correct_subquestions");
        $query->addSelect("countif('correct','=','2') as total_almost_subquestions");
        $query->addSelect("round((countif('correct','=','1') / count(distinct subquestion.id_subquestion))*100,2) as total_correct_subquestions_percents");

        $query->from(Model\Page::getClassName(),"page");

        $query->join(Model\Website::getClassName(),"website",Join::WITH,"page.id_website = website.id_website")->addSelect("website");
        $query->leftJoin(Model\Question::getClassName(),"question",Join::WITH,"page.id_page = question.id_page");
        $query->leftJoin(Model\Subquestion::getClassName(),"subquestion",Join::WITH,"question.id_question = subquestion.id_question");

        $query->andWhere($query->expr()->eq("website.visible",1));
        $query->andWhere($query->expr()->eq("page.visible",1));

        if($filter !== null){
            $this->createNumberCondition($filter->getIdsPages(), $query, "page.id_page");
            $this->createNumberCondition($filter->getSubquestions(), $query, "count(distinct subquestion.id_subquestion)",true);
            $this->createNumberCondition($filter->getCorrect(), $query, "countif('correct','=','1')",true);
            $this->createNumberCondition($filter->getAlmost(), $query, "countif('correct','=','2')",true);
            $this->createNumberCondition($filter->getPercentages(), $query, "round((countif('correct','=','1') / count(distinct subquestion.id_subquestion))*100,2)",true);

            if(is_array($filter->getOrderBy()) && count($filter->getOrderBy()) > 0){
                $this->createOrders($filter->getOrderBy(), $query);
            }else{
                $query->orderBy("website.id_website");
            }
        }


        $query->groupBy("page.id_page");

        return $this->getHolders($query, new \App\Holder\Mapper\Results\Base\Page());
    }

    /**
     * @return \App\Holder\Page
     */
    public function getBasePageHolders() {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("page");

        $query->from(Model\Page::getClassName(),"page");

        $query->join(Model\Website::getClassName(),"website",Join::WITH,"page.id_website = website.id_website")->addSelect("website");

        return $this->getHolders($query, new \App\Holder\Mapper\Page());
    }
}