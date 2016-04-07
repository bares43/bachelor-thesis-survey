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
     * @return \App\Holder\Results\Base\Base
     */
    public function getResultsBase() {
        return $this->database->getResultsBase();
    }

    /**
     * @return \App\Holder\Results\Base\RespondentsBase[]
     */
    public function getResultsRespondentsBase() {
        return $this->database->getResultsRespondentsBase();
    }

    /**
     * @param \App\Filter\Results\Respondents $filter
     * @return \App\Holder\Results\Base\Respondent[]
     */
    public function getResultsRespondent($filter = null) {
        return $this->database->getResultsRespondent($filter);
    }

    /**
     * @param $id_respondent
     * @return \App\Holder\Results\Respondent\Base
     */
    public function getResultsRespondentDetail($id_respondent) {
        return $this->database->getResultsRespondentDetail($id_respondent);
    }
}