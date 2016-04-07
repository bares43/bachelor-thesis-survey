<?php

/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 15:14
 */

namespace App\Database;

use App\Base\Database;
use Kdyby\Doctrine\Dql\Join;
use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Website extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Website::getClassName());
    }

    /**
     * @return Model\Website[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Website|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Website $website
     */
    public function save(Model\Website $website)
    {
        $this->_save($website);
    }

    /**
     * @param \App\Filter\Results\Websites $filter
     * @return \App\Holder\Results\Base\Page
     */
    public function getResultsWebsites($filter) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("website");
        $query->addSelect("count(distinct subquestion.id_subquestion) as total_subquestions");
        $query->addSelect("countif('state','=','1') as total_correct_subquestions");
        $query->addSelect("countif('state','=','2') as total_almost_subquestions");
        $query->addSelect("countif('state','=','0') as total_wrong_subquestions");
        $query->addSelect("countif('state','=','3') as total_disqualified_subquestions");
        $query->addSelect("round((countif('state','=','1') / (countif('state','=','0') + countif('state','=','1') + countif('state','=','2')))*100,2) as total_correct_subquestions_percents");

        $query->from(\App\Model\Website::getClassName(),"website");

        $query->join(\App\Model\Page::getClassName(),"page",Join::WITH,"page.id_website = website.id_website")->addSelect("website");
        $query->leftJoin(\App\Model\Question::getClassName(),"question",Join::WITH,"page.id_page = question.id_page");
        $query->leftJoin(\App\Model\Subquestion::getClassName(),"subquestion",Join::WITH,"question.id_question = subquestion.id_question");

        $query->andWhere($query->expr()->eq("website.visible",1));
        $query->andWhere($query->expr()->eq("page.visible",1));

        if($filter !== null){
            $this->createNumberCondition($filter->getIdsWebsites(), $query, "website.id_website");
            $this->createNumberCondition($filter->getSubquestions(), $query, "count(distinct subquestion.id_subquestion)",true);
            $this->createNumberCondition($filter->getCorrect(), $query, "countif('state','=','1')",true);
            $this->createNumberCondition($filter->getAlmost(), $query, "countif('state','=','2')",true);
            $this->createNumberCondition($filter->getWrong(), $query, "countif('state','=','0')",true);
            $this->createNumberCondition($filter->getDisqualified(), $query, "countif('state','=','3')",true);
            $this->createNumberCondition($filter->getPercentages(), $query, "round((countif('state','=','1') / (countif('state','=','0') + countif('state','=','1') + countif('state','=','2')))*100,2)",true);

            if(is_array($filter->getOrderBy()) && count($filter->getOrderBy()) > 0){
                $this->createOrders($filter->getOrderBy(), $query);
            }else{
                $query->orderBy("website.id_website");
            }
        }


        $query->groupBy("website.id_website");

        return $this->getHolders($query, new \App\Holder\Mapper\Results\Base\Website());
    }
}