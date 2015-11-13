<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 11. 11. 2015
 * Time: 21:28
 */

namespace App\Service;


use App\Base\Service;

class RespondentPageDuel extends Service {

    /** @var \App\Database\RespondentPageDuel */
    private $database;

    /**
     * RespondentPageDuel constructor.
     * @param \App\Database\RespondentPageDuel $database
     */
    public function __construct(\App\Database\RespondentPageDuel $database) {
        $this->database = $database;
    }

    /**
     * @param \App\Model\RespondentPageDuel $respondent_page_duel
     */
    public function save($respondent_page_duel) {
        $this->database->save($respondent_page_duel);
    }

    /**
     * @param int $id_page_related
     * @param int $id_respondent
     * @param int $more_often
     */
    public function addPageDuelToRespondent($id_page_related, $id_respondent, $more_often, $id_page) {
        $respondent_page_duel = new \App\Model\RespondentPageDuel();
        $respondent_page_duel->id_respondent = $id_respondent;
        $respondent_page_duel->id_page_related = $id_page_related;
        $respondent_page_duel->more_often = $more_often;
        $respondent_page_duel->id_page = $id_page;
        $this->database->save($respondent_page_duel);
    }
}