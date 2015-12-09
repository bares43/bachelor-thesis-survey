<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 1. 12. 2015
 * Time: 13:17
 */

namespace App\Presenters;


use App\Base\Presenter;
use App\Service\Respondent;

class HighscorePresenter extends Presenter{

    /** @var Respondent @inject */
    public $respondent_service;

    public function renderDefault() {
        $this->template->highscore = $this->respondent_service->getHighscore();
        $this->template->id_respondent = $this->getSession()->getSection("survey")->id_respondent;
    }
}