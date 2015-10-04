<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:29
 */

namespace App\Service;


use App\Base\Service;
use Nette\Utils\ArrayHash;

class Subquestion extends Service {

    /** @var \App\Database\Subquestion */
    private $database;

    /** @var Wireframe */
    private $wireframe_service;

    /** @var Question */
    private $question_service;

    /**
     * Subquestion constructor.
     * @param \App\Database\Subquestion $db_subquestion
     * @param Wireframe $wireframe_service
     * @param Question $question_service
     */
    public function __construct(\App\Database\Subquestion $db_subquestion, Wireframe $wireframe_service, Question $question_service) {
        $this->database = $db_subquestion;
        $this->wireframe_service = $wireframe_service;
        $this->question_service = $question_service;
    }

    /**
     * @param $id_subquestion
     * @return \App\Model\Subquestion|null
     */
    public function get($id_subquestion) {
        return $this->database->get($id_subquestion);
    }

    /**
     * @return \App\Model\Subquestion[]
     */
    public function getAll() {
        return $this->database->getAll();
    }

    /**
     * @param \App\Model\Subquestion $subquestion
     */
    public function save($subquestion) {
        $this->database->save($subquestion);
    }

    /**
     * @param ArrayHash $values
     * @param int $id_respondent
     * @return int
     */
    public function getIdQuestion($values, $id_respondent) {
        if($values->id_question != null) return $values->id_question;

        $id_page = $values->id_page;

        $question = $this->question_service->create($id_respondent, $id_page);
        return $question->id_question;
    }

    /**
     * @param ArrayHash $values
     * @param int $type
     * @param int $id_respondent
     * @return \App\Model\Subquestion
     */
    public function prepareSubquestionForSave($values, $type, $id_respondent){
        $id_question = $this->getIdQuestion($values, $id_respondent);

        $subquestion = new \App\Model\Subquestion();
        $subquestion->question_type = $type;
        $subquestion->id_question = $id_question;
        $subquestion->id_wireframe = $values->id_wireframe;
        $subquestion->reason = $values->reason;
        $subquestion->seconds = $values->seconds;

        return $subquestion;
    }

}