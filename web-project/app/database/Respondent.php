<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:07
 */
namespace App\Database;

use App\Base\Database;
use App\Holder\Highscore;
use Kdyby\Doctrine\Dql\Join;
use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Respondent extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Respondent::getClassName());
    }

    /**
     * @return Model\Respondent[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Respondent|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Respondent $respondent
     */
    public function save(Model\Respondent $respondent)
    {
        if($respondent->datetime === null) $respondent->datetime = new \DateTime();
        $this->_save($respondent);
    }

    /**
     * @return Highscore[]
     */
    public function getHighscore() {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("respondent");
        $query->addSelect("max(subquestion.datetime) as date");
        $query->addSelect("count(subquestion.id_subquestion) as count_questions");
        $query->addSelect("countif('correct','=','1') as count_correct");

        $query->from(Model\Respondent::getClassName(),"respondent");

        $query->where($query->expr()->isNotNull("respondent.nickname"));
        $query->where($query->expr()->gt($query->expr()->length($query->expr()->trim("respondent.nickname")),0));


        $query->join(Model\Question::getClassName(),"question",Join::WITH,"question.id_respondent = respondent.id_respondent");
        $query->join(Model\Subquestion::getClassName(),"subquestion",Join::WITH,"subquestion.id_question = question.id_question");

        $query->groupBy("respondent.id_respondent");

        $query->orderBy("count_correct","desc");


        $mapper = new \App\Holder\Mapper\Highscore();

        return $this->getHolders($query, $mapper);
    }
}