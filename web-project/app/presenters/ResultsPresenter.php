<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 13:25
 */

namespace App\Presenters;


use App\Base\Presenter;
use App\Service\Question;
use App\Service\Respondent;

class ResultsPresenter extends Presenter{

    /** @var Respondent @inject */
    public $respondent_service;

    /** @var  Question @inject */
    public $question_service;

    public function renderDefault() {

        $this->template->base = $this->respondent_service->getResultsBase();
        $this->template->base_respondents = $this->respondent_service->getResultsRespondentsBase();
        $this->template->respondents = $this->respondent_service->getResultsRespondent();
        $this->template->subquestions = $this->question_service->getResultsSubquestion();

    }
}