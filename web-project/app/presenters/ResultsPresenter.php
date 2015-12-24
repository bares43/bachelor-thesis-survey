<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 13:25
 */

namespace App\Presenters;

use App\Base\Presenter;
use App\Filter\Results\RespondentCategory;
use App\Filter\Results\Subquestions;
use App\Service\EntityCategory;
use App\Service\Page;
use App\Service\Question;
use App\Service\Respondent;
use App\Service\Subquestion;
use App\Service\Website;

class ResultsPresenter extends Presenter {

    /** @var Respondent @inject */
    public $respondent_service;

    /** @var  Question @inject */
    public $question_service;

    /** @var  Page @inject */
    public $page_service;

    /** @var  Subquestion @inject */
    public $subquestion_service;

    /** @var  EntityCategory @inject */
    public $entity_category_service;

    /** @var Website @inject */
    public $website_service;

    public function startup() {

        parent::startup();

        if(!$this->getUser()->isLoggedIn()){
            $this->redirect('Sign:login');
        }
    }


    public function renderDefault() {
        $this->template->base = $this->respondent_service->getResultsBase();
        $this->template->base_respondents = $this->respondent_service->getResultsRespondentsBase();
//
//        $subquestions = $this->getComponent("subquestions");
//        $subquestions->setSubquestions($this->question_service->getResultsSubquestion());
//        $this->template->subquestions = $subquestions;

//        $this->template->subquestions = $this->question_service->getResultsSubquestion();
        $this->template->pages = $this->page_service->getResultsPages();
    }

    public function renderRespondent($id_respondent) {
        if($id_respondent === null) $this->redirect("Results:");

        $respondent = $this->respondent_service->getResultsRespondentDetail($id_respondent);
        if(!$respondent) $this->redirect("Results:");

        $this->template->respondent = $respondent;

        $this->template->subquestions = $this->question_service->getResultsSubquestion(new Subquestions(array(
            Subquestions::ID_RESPONDENTS => $id_respondent
        )));

        $this->template->categories = $this->entity_category_service->getResultsRespondentCategory(new RespondentCategory(array(
            RespondentCategory::ID_RESPONDENT => $id_respondent
        )));
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

    public function actionVisibility($id_subquestion, $visibility) {
        if($id_subquestion !== null && ($visibility === "true" || $visibility === "false")){
            $subquestion = $this->subquestion_service->get($id_subquestion);
            if($subquestion !== null){
                $subquestion->visible = $visibility === "true";
                $this->subquestion_service->save($subquestion);

                $this->setView("subquestionvisibility");
                $this->template->visibility = $subquestion->visible;
                $this->template->id_subquestion = $subquestion->id_subquestion;

            }else{

                $this->terminate();
            }
        }else{

            $this->terminate();
        }

    }

    public function createComponentSubquestions() {
        $subquestions = new \App\Components\Subquestions($this->question_service, $this->website_service, $this->page_service);
        return $subquestions;
    }

    public function createComponentRespondents() {
        $respondents = new \App\Components\Respondents($this->respondent_service);
        return $respondents;
    }

    public function createComponentPages() {
        $pages = new \App\Components\Pages($this->page_service);
        return $pages;
    }


}