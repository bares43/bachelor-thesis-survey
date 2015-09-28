<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:29
 */

namespace App\Service;


use App\Base\Service;

class Question extends Service {

    /** @var \App\Database\Question */
    private $database;

    /**
     * Question constructor.
     * @param \App\Database\Question $db_question
     */
    public function __construct(\App\Database\Question $db_question) {
        $this->database = $db_question;
    }

    /**
     * @param $id_question
     * @return \App\Model\Question|null
     */
    public function get($id_question) {
        return $this->database->get($id_question);
    }

    /**
     * @return \App\Model\Question[]
     */
    public function getAll() {
        return $this->database->getAll();
    }

    /**
     * @param \App\Model\Question $question
     */
    public function save($question) {
        $this->database->save($question);
    }

    /**
     * @param int $id_respondent
     * @param int $id_page
     * @return \App\Model\Question
     */
    public function create($id_respondent, $id_page) {
        return $this->database->create($id_respondent, $id_page);
    }

}