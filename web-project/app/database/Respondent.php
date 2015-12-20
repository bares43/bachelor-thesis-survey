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
use App\Holder\Base;
use App\Holder\ResultsBaseRespondent;
use App\Holder\ResultsBaseRespondentsBase;
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
        $query->addSelect("(countif('correct','=','1') * (1+(countif('correct','=','1')/count(subquestion.id_subquestion)))) as score");


        $query->from(Model\Respondent::getClassName(),"respondent");

        $query->where($query->expr()->isNotNull("respondent.nickname"));
        $query->where($query->expr()->gt($query->expr()->length($query->expr()->trim("respondent.nickname")),0));


        $query->join(Model\Question::getClassName(),"question",Join::WITH,"question.id_respondent = respondent.id_respondent");
        $query->join(Model\Subquestion::getClassName(),"subquestion",Join::WITH,"subquestion.id_question = question.id_question");

        $query->groupBy("respondent.id_respondent");

        $query->orderBy("score","desc");


        $mapper = new \App\Holder\Mapper\Highscore();

        return $this->getHolders($query, $mapper);
    }

    /**
     * @return \App\Holder\Results\Base\Base
     */
    public function getResultsBase() {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

//        $query->select("respondent");

        // total respondents
        $query->addSelect("count(distinct respondent.id_respondent) as total_respondents");
        // total questions
        $query->addSelect("count(distinct question.id_question) as total_questions");
        // total subquestions
        $query->addSelect("count(distinct subquestion.id_subquestion) as total_subquestions");
        // total correct subquestions
        $query->addSelect("countif('correct','=','1') as total_correct_subquestions");
        // total wrong subquestions
        $query->addSelect("countif('correct','=','0') as total_wrong_subquestions");
        // avg seconds
        $query->addSelect("avg(subquestion.seconds) as avg_seconds");
        // total male
        $query->addSelect("countif('gender','=','\"".Model\Respondent::GENDER_MALE."\"') as total_male");
        // total female
        $query->addSelect("countif('gender','=','\"".Model\Respondent::GENDER_FEMALE."\"') as total_female");
        // total gender unknown
        $query->addSelect("countif('gender','is','null') as total_gender_unknown");
        // total 15
        $query->addSelect("countif('gender','=','\"".Model\Respondent::AGE_15."\"') as total_15");
        // total 15_20
        $query->addSelect("countif('gender','=','\"".Model\Respondent::AGE_15_20."\"') as total_15_20");
        // total 21_30
        $query->addSelect("countif('gender','=','\"".Model\Respondent::AGE_21_30."\"') as total_21_30");
        // total 31_45
        $query->addSelect("countif('gender','=','\"".Model\Respondent::AGE_31_45."\"') as total_31_45");
        // total 46_60
        $query->addSelect("countif('gender','=','\"".Model\Respondent::AGE_46_60."\"') as total_46_60");
        // total 60
        $query->addSelect("countif('gender','=','\"".Model\Respondent::AGE_60."\"') as total_60");
        // total age unknown
        $query->addSelect("countif('gender','is','null') as total_age_unknown");

        $query->from(Model\Respondent::getClassName(),"respondent");


        $query->leftJoin(Model\Question::getClassName(),"question",Join::WITH,"question.id_respondent = respondent.id_respondent");
        $query->leftJoin(Model\Subquestion::getClassName(),"subquestion",Join::WITH,"subquestion.id_question = question.id_question");

        return $this->getHolder($query, new \App\Holder\Mapper\Results\Base\Base());
    }

    /**
     * @return \App\Holder\Results\Base\RespondentsBase[]
     */
    public function getResultsRespondentsBase() {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();


        // total male
        $query->addSelect("countif('gender','=','\"".Model\Respondent::GENDER_MALE."\"') as total_male");
        // total female
        $query->addSelect("countif('gender','=','\"".Model\Respondent::GENDER_FEMALE."\"') as total_female");
        // total gender unknown
        $query->addSelect("countif('gender','is','null') as total_gender_unknown");
        // total 15
        $query->addSelect("countif('age','=','\"".Model\Respondent::AGE_15."\"') as total_15");
        // total 15_20
        $query->addSelect("countif('age','=','\"".Model\Respondent::AGE_15_20."\"') as total_15_20");
        // total 21_30
        $query->addSelect("countif('age','=','\"".Model\Respondent::AGE_21_30."\"') as total_21_30");
        // total 31_45
        $query->addSelect("countif('age','=','\"".Model\Respondent::AGE_31_45."\"') as total_31_45");
        // total 46_60
        $query->addSelect("countif('age','=','\"".Model\Respondent::AGE_46_60."\"') as total_46_60");
        // total 60
        $query->addSelect("countif('age','=','\"".Model\Respondent::AGE_60."\"') as total_60");
        // total age unknown
        $query->addSelect("countif('age','is','null') as total_age_unknown");
        // total english
        $query->addSelect("countif('english','=','1') as total_english");
        // total it
        $query->addSelect("countif('it','=','1') as total_it");
        // total computer
        $query->addSelect("countif('device_computer','=','1') as total_computer");
        // total tablet
        $query->addSelect("countif('device_tablet','=','1') as total_tablet");
        // total phone
        $query->addSelect("countif('device_phone','=','1') as total_phone");
        // total most computer
        $query->addSelect("countif('device_most','=','\"".Model\Respondent::DEVICE_COMPUTER."\"') as total_most_computer");
        // total most tablet
        $query->addSelect("countif('device_most','=','\"".Model\Respondent::DEVICE_TABLET."\"') as total_most_tablet");
        // total most phone
        $query->addSelect("countif('device_most','=','\"".Model\Respondent::DEVICE_PHONE."\"') as total_most_phone");
        // total most unknown
        $query->addSelect("countif('device_most','is','null') as total_most_device_unknown");

        $query->from(Model\Respondent::getClassName(),"respondent");

        return $this->getHolder($query, new \App\Holder\Mapper\Results\Base\RespondentsBase());
    }

    /**
     * @param \App\Filter\Results\Respondents $filter
     * @return \App\Holder\Results\Base\Respondent[]
     */
    public function getResultsRespondent($filter = null) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("respondent");
        $query->addSelect("count(distinct question.id_question) as total_questions");
        $query->addSelect("count(distinct subquestion.id_subquestion) as total_subquestions");
        $query->addSelect("countif('correct','=','1') as total_correct_subquestions");
        $query->addSelect("countif('correct','=','0') as total_wrong_subquestions");
        $query->addSelect("countif('correct','is','null') as total_unknown_subquestions");
        $query->addSelect("round((countif('correct','=','1') / count(distinct subquestion.id_subquestion))*100,2) as total_correct_subquestions_percents");


        $query->from(Model\Respondent::getClassName(),"respondent");

        $query->leftJoin(Model\Question::getClassName(),"question",Join::WITH,"question.id_respondent = respondent.id_respondent");
        $query->leftJoin(Model\Subquestion::getClassName(),"subquestion",Join::WITH,"subquestion.id_question = question.id_question");

        if($filter !== null){
            $this->createNumberCondition($filter->getRespondents(), $query, "respondent.id_respondent");
            $this->createNumberCondition($filter->getPercentages(), $query, "round((countif('correct','=','1') / count(distinct subquestion.id_subquestion))*100,2)", true);
            $this->createNumberCondition($filter->getQuestions(), $query, "count(distinct question.id_question)", true);
            $this->createNumberCondition($filter->getSubquestions(), $query, "count(distinct subquestion.id_subquestion)", true);
            $this->createNumberCondition($filter->getCorrects(), $query, "countif('correct','=','1')", true);
            $this->createNumberCondition($filter->getWrongs(), $query, "countif('correct','=','0')", true);
            $this->createNumberCondition($filter->getUnknowns(), $query, "countif('correct','is','null')", true);

            $this->createNumberCondition($filter->getDatetimes(), $query, "date(respondent.datetime)");
            $this->createNumberCondition($filter->getAges(), $query, "respondent.age");
            $this->createNumberCondition($filter->getGenders(), $query, "respondent.gender");
            $this->createNumberCondition($filter->getEnglishes(), $query, "respondent.english");
            $this->createNumberCondition($filter->getIts(), $query, "respondent.it");

            $this->createStringCondition($filter->getWebsites(), $query, "respondent.sites");

            if(is_array($filter->getOrderBy()) && count($filter->getOrderBy()) > 0){
                $this->createOrders($filter->getOrderBy(), $query);
            }else{
                $query->orderBy("respondent.id_respondent","desc");
            }

        }

        $query->groupBy("respondent.id_respondent");


        return $this->getHolders($query, new \App\Holder\Mapper\Results\Base\Respondent());
    }

    /**
     * @param $id_respondent
     * @return \App\Holder\Results\Respondent\Base
     */
    public function getResultsRespondentDetail($id_respondent) {
        $query = $this->entityManager->getRepository($this->repositoryName)->createQueryBuilder();

        $query->select("respondent");
        $query->addSelect("count(distinct question.id_question) as total_questions");
        $query->addSelect("count(distinct subquestion.id_subquestion) as total_subquestions");
        $query->addSelect("countif('correct','=','1') as total_correct_subquestions");
        $query->addSelect("countif('correct','=','0') as total_wrong_subquestions");
        $query->addSelect("countif('correct','is','null') as total_unknown_subquestions");
        $query->addSelect("avg(subquestion.seconds) avg_seconds");
        $query->addSelect("sum(subquestion.seconds) total_seconds");


        $query->from(Model\Respondent::getClassName(),"respondent");

        $query->leftJoin(Model\Question::getClassName(),"question",Join::WITH,"question.id_respondent = respondent.id_respondent");
        $query->leftJoin(Model\Subquestion::getClassName(),"subquestion",Join::WITH,"subquestion.id_question = question.id_question");


        $query->where($query->expr()->eq("respondent.id_respondent",$id_respondent));

        return $this->getHolder($query, new \App\Holder\Mapper\Results\Respondent\Base());
    }
}