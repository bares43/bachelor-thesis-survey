<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:06
 */
namespace App\Database;

use App\Base\Database;
use App\Holder\Mapper\ResultsQuestion;
use Doctrine\ORM\Query\Expr\Join;
use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Question extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Question::getClassName());
    }

    /**
     * @return Model\Question[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Question|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Question $question
     */
    public function save(Model\Question $question)
    {
        if($question->datetime === null) $question->datetime = new \DateTime();
        $this->_save($question);
    }

    /**
     * @param int $id_respondent
     * @return Model\Question[]
     */
    public function getByIdRespondent($id_respondent) {
        return $this->entityManager->getRepository($this->repositoryName)->findBy(array("id_respondent"=>$id_respondent));
    }

    /**
     * @param int $id_page
     * @param int|null $id_respondent
     * @return Model\Question
     */
    public function create($id_page, $id_respondent = null)
    {
        $question = new Model\Question();
        $question->id_respondent = $id_respondent;
        $question->id_page = $id_page;
        $this->save($question);
        return $question;
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
     * @param \App\Filter\Results\Subquestions $filter
     * @return \App\Holder\Results\Base\Question[]
     */
    public function getResultsSubquestion($filter = null) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("subquestion");
        $query->addSelect("question");

        $query->from(Model\Subquestion::getClassName(),"subquestion");

        $query->join(Model\Question::getClassName(),"question",Join::WITH,"subquestion.id_question = question.id_question")->addSelect("question");
        $query->join(Model\Page::getClassName(),"page",Join::WITH,"question.id_page = page.id_page")->addSelect("page");
        $query->join(Model\Website::getClassName(),"website",Join::WITH,"page.id_website = website.id_website")->addSelect("website");
        $query->join(Model\Respondent::getClassName(),"respondent",Join::WITH,"question.id_respondent = respondent.id_respondent")->addSelect("respondent");
        $query->leftJoin(Model\RespondentWebsite::getClassName(),"respondentwebsite",Join::WITH,$query->expr()->andX(
            $query->expr()->eq('respondent.id_respondent', 'respondentwebsite.id_respondent'),
            $query->expr()->eq('website.id_website', 'respondentwebsite.id_website')
        ))->addSelect("respondentwebsite");


        if($filter !== null){
            if($filter->getIdRespondent() !== null && $filter->getIdRespondent() > 0){
                $query->andWhere($query->expr()->eq("respondent.id_respondent",$filter->getIdRespondent()));
            }
        }

        $query->orderBy("subquestion.id_subquestion","desc");

        return $this->getHolders($query, new \App\Holder\Mapper\Results\Base\Question());
    }
}