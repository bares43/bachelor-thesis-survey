<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:29
 */

namespace App\Service;


use App\Base\Service;
use App\Holder\Highscore;

class Respondent extends Service {

    /** @var \App\Database\Respondent */
    private $database;

    /**
     * Respondent constructor.
     * @param \App\Database\Respondent $database
     */
    public function __construct(\App\Database\Respondent $database) {
        $this->database = $database;
    }

    /**
     * @param $id_respondent
     * @return \App\Model\Respondent|null
     */
    public function get($id_respondent) {
        return $this->database->get($id_respondent);
    }

    /**
     * @return \App\Model\Respondent[]
     */
    public function getAll() {
        return $this->database->getAll();
    }

    /**
     * @param \App\Model\Respondent $respondent
     */
    public function save($respondent) {
        $this->database->save($respondent);
    }

    /**
     * @return Highscore[]
     */
    public function getHighscore() {
        return $this->database->getHighscore();
    }

    /**
     * @return \App\Holder\ResultsBase
     */
    public function getResultsBase() {
        return $this->database->getResultsBase();
    }

    /**
     * @return \App\Holder\ResultsRespondentsBase
     */
    public function getResultsRespondentsBase() {
        return $this->database->getResultsRespondentsBase();
    }

    /**
     * @return \App\Holder\ResultsRespondent[]
     */
    public function getResultsRespondent() {
        return $this->database->getResultsRespondent();
    }
}