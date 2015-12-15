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
use App\Service\Subquestion;

class ResultsPresenter extends Presenter {

    /** @var Respondent @inject */
    public $respondent_service;

    /** @var  Question @inject */
    public $question_service;

    /** @var  Page @inject */
    public $page_service;

    /** @var  Subquestion @inject */
    public $subquestion_service;

    public function startup() {

        parent::startup();

        if(!$this->getUser()->isLoggedIn()){
            $this->redirect('Sign:login');
        }
    }

    public function actionEvaluate($id_subquestion, $correct) {
        if($id_subquestion !== null && ($correct === "correct" || $correct === "wrong")){
            $subquestion = $this->subquestion_service->get($id_subquestion);
            if($subquestion !== null){
                $subquestion->correct = $correct === "correct";
                $this->subquestion_service->save($subquestion);

                $this->setView("subquestioncorrect");
                $this->template->correct = $subquestion->correct;

            }else{

                $this->terminate();
            }
        }else{

            $this->terminate();
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