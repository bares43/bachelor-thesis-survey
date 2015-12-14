<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 13:25
 */

namespace App\Presenters;

use App\Base\Presenter;
use App\Service\Page;
use App\Service\Question;
use App\Service\Respondent;

class ResultsPresenter extends Presenter {

    /** @var Respondent @inject */
    public $respondent_service;

    /** @var  Question @inject */
    public $question_service;

    /** @var  Page @inject */
    public $page_service;

    public function startup() {

        parent::startup();

        if(!$this->getUser()->isLoggedIn()){
            $this->redirect('Sign:login');
        }
    }

    public function renderDefault() {
        $this->template->base = $this->respondent_service->getResultsBase();
        $this->template->base_respondents = $this->respondent_service->getResultsRespondentsBase();
        $this->template->respondents = $this->respondent_service->getResultsRespondent();
        $this->template->subquestions = $this->question_service->getResultsSubquestion();
        $this->template->pages = $this->page_service->getResultsPages();
    }

}