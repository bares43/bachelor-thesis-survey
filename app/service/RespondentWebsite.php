<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 3. 10. 2015
 * Time: 12:40
 */

namespace App\Service;


use App\Base\Service;

class RespondentWebsite extends Service {

    /** @var \App\Database\RespondentWebsite */
    private $database;

    /**
     * RespondentWebsite constructor.
     * @param \App\Database\RespondentWebsite $database
     */
    public function __construct(\App\Database\RespondentWebsite $database) {
        $this->database = $database;
    }

    /**
     * @param \App\Model\RespondentWebsite $respondent
     */
    public function save($respondent) {
        $this->database->save($respondent);
    }

    /**
     * @param int $id_website
     * @param int $id_respondent
     * @param int $period
     */
    public function addWebsiteToRespondent($id_website, $id_respondent, $period) {
        $respondent_website = new \App\Model\RespondentWebsite();
        $respondent_website->id_website = $id_website;
        $respondent_website->id_respondent = $id_respondent;
        $respondent_website->period = $period;
        $this->database->save($respondent_website);
    }

}