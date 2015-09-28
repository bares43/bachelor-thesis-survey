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
     * @param int $id_respondent
     * @return \App\Holder\Subquestion[]
     */
    public function getSubquestionHoldersByIdRespondent($id_respondent) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("subquestion");
        $query->from(Model\Subquestion::getClassName(),"subquestion");

        $query->join(Model\Question::getClassName(),"question",Join::WITH,"subquestion.id_question = question.id_question")->addSelect("question");
        $query->leftJoin(Model\Wireframe::getClassName(),"wireframe",Join::WITH,"subquestion.id_wireframe = wireframe.id_wireframe")->addSelect("wireframe");
        $query->join(Model\Page::getClassName(),"page",Join::WITH,"question.id_page = page.id_page")->addSelect("page");
        $query->join(Model\Website::getClassName(),"website",Join::WITH,"page.id_website = website.id_website")->addSelect("website");

        $query->where($query->expr()->eq("question.id_respondent",$id_respondent));

        $mapper = new \App\Holder\Mapper\Subquestion();

        return $this->populateMapper($query, $mapper);
    }


    /**
     * @param Model\Subquestion $subquestion
     */
    public function save(Model\Subquestion $subquestion)
    {
        $this->_save($subquestion);
    }

}
