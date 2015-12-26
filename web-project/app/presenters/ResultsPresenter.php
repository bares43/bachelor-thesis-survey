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
        $this->template->pages = $this->page_service->getResultsPages();
    }

    public function renderRespondent($id_respondent) {
        if($id_respondent === null) $this->redirect("Results:");

        $respondent = $this->respondent_service->getResultsRespondentDetail($id_respondent);
        if(!$respondent) $this->redirect("Results:");

        $this->template->respondent = $respondent;

        $this->template->categories = $this->entity_category_service->getResultsRespondentCategory(new RespondentCategory(array(
            RespondentCategory::ID_RESPONDENT => $id_respondent
        )));
    }

    public function createComponentSubquestions() {
        $subquestions = new \App\Components\Subquestions($this->question_service, $this->website_service, $this->page_service, $this->subquestion_service);
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