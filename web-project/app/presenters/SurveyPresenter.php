<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 21:19
 */

namespace App\Presenters;

use App\Forms\BaseSurveyForm;
use App\Forms\ColorForm;
use App\Forms\ColorSelectForm;
use App\Forms\FinalForm;
use App\Forms\PersonalForm;
use App\Forms\WireframeForm;
use App\Forms\WireframeReverse;
use App\Forms\WireframeSelectForm;
use App\Service\Page;
use App\Service\Question;
use App\Service\Respondent;
use App\Service\Subquestion;
use App\Service\Website;
use App\Service\Wireframe;
use Nette;
use Nette\Application\UI\Form;

class SurveyPresenter extends Nette\Application\UI\Presenter {

    /** @var Website @inject */
    public $website_service;

    /** @var Page @inject */
    public $page_service;

    /** @var Respondent @inject */
    public $respondent_service;

    /** @var Question @inject */
    public $question_service;

    /** @var Subquestion @inject */
    public $subquestion_service;

    /** @var Wireframe @inject */
    public $wireframe_service;

    /** @var Nette\Http\SessionSection */
    private $sessionSection;

    /** @var int */
    private $id_question;

    /** @var int */
    private $id_page;

    /** @var int */
    private $id_wireframe;

    protected function startup() {
        parent::startup();

        $this->sessionSection = $this->getSession()->getSection("survey");

        if($this->sessionSection->next_personal && $this->sessionSection->respondent === null && $this->action !== "personal"){
            $this->redirect("Survey:personal");
            exit;
        }

        if($this->sessionSection->respondent === null){
            $this->sessionSection->next_personal = true;
        }
    }

    /**
     * ACTION
     */

    public function actionDefault(){
        $this->redirect("Survey:personal");
    }

    public function actionQuestion(){
        $options_wireframes = array(
            \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME=>0,
            \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_SELECT=>0,
            \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE=>0
        );
        $options_colors = array(
            \App\Model\Subquestion::QUESTION_TYPE_COLOR=>0,
            \App\Model\Subquestion::QUESTION_TYPE_COLOR_SELECT=>0
        );
        $options = array_merge($options_wireframes, $options_colors);

        $filter = new \App\Filter\Page;

        // chci údaje o respondentovi
        /** @var Respondent $respondent */
        $respondent = $this->sessionSection->respondent;
        // chci respondentovy odpovědi

        $last_question = null;

        /** @var \App\Model\Page $page */
        $page = null;
        /** @var \App\Model\Wireframe $wireframe */
        $wireframe = null;
        $question_type = null;
        /** @var \App\Model\Question $question */
        $question = null;

        if($respondent !== null){
            /** @var \App\Holder\Subquestion[] $subquestions */
            $subquestions = $this->subquestion_service->getSubquestionHoldersByIdRespondent($respondent->id_respondent);

            $rand = rand(1,100);

            if(count($subquestions) > 0) {

                $pages_ids = array();
                foreach($subquestions as $holder){
                    $pages_ids[] = $holder->getPage()->id_page;

                    $options[$holder->getSubquestion()->question_type]++;
                }
                $pages_ids_part = array_slice($pages_ids,ceil(count($pages_ids)/2));
                $pages_ids = array_unique($pages_ids);
                arsort($options);

                /** @var \App\Holder\Subquestion $last_subquestion */
                $last_subquestion = end($subquestions);

                if ($rand >= 1 && $rand <= 20 && $last_subquestion->getSubquestion()->correct !== null && !$last_subquestion->getSubquestion()->correct) {
                    $page = $last_subquestion->getPage();
                    if(in_array($last_subquestion->getSubquestion()->question_type,array_keys($options_wireframes))){
                        $question_type = array_rand($options_colors);
                    }else{
                        $question_type = array_rand($options_wireframes);
                    }
                    $question = $last_subquestion->getQuestion();
                } else if ($rand >= 80 && $rand <= 100) {
                    // vyberu nahodou subquestion a pro stejnou page jiny typ otazky, odfiltrovat poslednich X pages
                } else if($rand >= 21 && $rand <= 35){
                    // odfiltrovat vsechny pages, zobrazit prioritni page, NErespektovat nastaveni respondenta
                    $holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                        array(
                            \App\Filter\Page::PRIORITY=>true,
                            \App\Filter\Page::EXCLUDE_ID_PAGE=>$pages_ids
                        )
                    ));
                    if($holder !== null){
                        $page = $holder->getPage();
                        $wireframe = $holder->getWireframe();
                        $question_type = array_rand($options_wireframes);
                    }
                }
                if($page === null){
                    // nahodna page, respektovat nastaveni respondenta, odfiltrovat X poslednich pages
                    $holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                        array(
                            \App\Filter\Page::PRIORITY=>true,
                            \App\Filter\Page::EXCLUDE_ID_PAGE=>$pages_ids_part
                        )
                    ));
                    if($holder !== null){
                        $page = $holder->getPage();
                        $wireframe = $holder->getWireframe();
                        $question_type = array_rand($options_wireframes);
                    }
                }
            }else{
                // nahodna page, respektovat nastaveni respondenta
                $holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                    array(\App\Filter\Page::PRIORITY=>true)
                ));
                if($holder !== null){
                    $page = $holder->getPage();
                    $wireframe = $holder->getWireframe();
                    $question_type = array_rand($options_wireframes);
                }
            }


            $languages = array(\App\Model\Website::LANGUAGE_CZECH);
            if($respondent->english) $languages[] = \App\Model\Website::LANGUAGE_ENGLISH;

            $filter->setLanguages($languages);
        }

        if($page === null){
            $holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                array(\App\Filter\Page::PRIORITY=>true)
            ));
            $page = $holder->getPage();
            $wireframe = $holder->getWireframe();
            $question_type = array_rand($options_wireframes);
        }

        switch($question_type){
            case \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_SELECT:
                $view = "wireframeselect";
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE:
                $view = "wireframereverse";
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_COLOR:
                $view = "color";
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_COLOR_SELECT:
                $view = "colorselect";
                break;
            default:
                $view = "wireframe";
        }
        $this->setView($view);

        $this->id_page = $page->id_page;
        if($wireframe !== null){
            $this->id_wireframe = $wireframe->id_wireframe;
        }
        if($question !== null){
            $this->id_question = $question->id_question;
        }

    }

    public function actionPersonal(){
        if($this->sessionSection->respondent !== null){
            $this->setView("continue");
        }
    }

    public function actionNewRespondent(){
        $this->sessionSection->respondent = null;
        $this->redirect("Survey:personal");
    }

    /**
     * RENDER
     */

    public function renderWireframe(){
        $this->template->answer_btn = "#frm-wireframeForm-page";
        $this->template->help_lorem = true;
        $this->template->help_gray = true;
        $this->template->help_blur = true;
        $this->template->id_wireframe = $this->id_wireframe;
        $this->template->form = $this->createComponentWireframeForm();
    }

    public function renderWireframeselect(){
        $this->template->answer_btn = "#frm-wireframeForm-page";
        $this->template->help_lorem = true;
        $this->template->help_gray = true;
        $this->template->help_blur = true;
        $this->template->id_wireframe = $this->id_wireframe;
        $this->template->form = $this->createComponentWireframeSelectForm();
    }

    public function renderWireframereverse(){
        $this->template->help_lorem = true;
        $this->template->help_gray = true;
        $this->template->id_wireframe = $this->id_wireframe;
        $this->template->form = $this->createComponentWireframeReverseForm();
    }

    public function renderColor(){
        $this->template->color = "3397C7";
        $this->template->answer_btn = "#frm-colorForm-answer";
        $this->template->help_lorem = true;
        $this->template->form = $this->createComponentColorForm();
    }

    public function renderColorselect(){
        $this->template->color = "3397C7";
        $this->template->help_lorem = true;
        $this->template->form = $this->createComponentColorSelectForm();
    }

    public function renderFinal(){
        $this->template->form = $this->createComponentFinalForm();
    }


    /** FORMS SUCCESS */

    /**
     * @param Form $form
     */
    public function personalFormSubmitted(Form $form){
        $values = $form->getValues();

        $respondent = new \App\Model\Respondent();
        $respondent->gender = $values->gender;
        $respondent->age = $values->age;
        $respondent->english = $values->english === 1;
        if(is_array($values->device)){
            $respondent->device_phone = in_array(\App\Model\Respondent::DEVICE_PHONE, $values->device);
            $respondent->device_tablet = in_array(\App\Model\Respondent::DEVICE_TABLET, $values->device);
            $respondent->device_computer = in_array(\App\Model\Respondent::DEVICE_COMPUTER, $values->device);
        }
        $respondent->device_most = $values->device_most;
        $respondent->email = $values->email;
        $respondent->message = $values->message;
        $respondent->sites = $values->sites;
        $this->respondent_service->save($respondent);

        $this->sessionSection->next_personal = false;
        $this->sessionSection->respondent = $respondent;

        $this->redirect("Survey:question");
    }

    /**
     * @param Form $form
     */
    public function wireframeFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->subquestion_service->prepareSubquestionForSave($values, \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME,$this->sessionSection->respondent->id_respondent);

        $subquestion->answer = $values->answer;

        $this->subquestion_service->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }

        $this->redirect("Survey:question");
        exit;
    }

    /**
     * @param Form $form
     */
    public function wireframeSelectFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->subquestion_service->prepareSubquestionForSave($values, \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_SELECT,$this->sessionSection->respondent->id_respondent);

        $subquestion->correct = $values->id_pages === $values->id_page;
        $subquestion->answer = $values->id_pages;

        $this->subquestion_service->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }

        $this->redirect("Survey:question");
        exit;
    }

    /**
     * @param Form $form
     */
    public function wireframeReverseFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->subquestion_service->prepareSubquestionForSave($values, \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE,$this->sessionSection->respondent->id_respondent);

        $subquestion->correct = $values->id_pages === $values->id_page;
        $subquestion->answer = $values->id_pages;

        $this->subquestion_service->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }

        $this->redirect("Survey:question");
        exit;
    }

    /**
     * @param Form $form
     */
    public function colorFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->subquestion_service->prepareSubquestionForSave($values, \App\Model\Subquestion::QUESTION_TYPE_COLOR, $this->sessionSection->respondent->id_respondent);

        $subquestion->answer = $values->answer;

        $this->subquestion_service->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }

        $this->redirect("Survey:question");
        exit;
    }

    /**
     * @param Form $form
     */
    public function colorSelectFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->subquestion_service->prepareSubquestionForSave($values, \App\Model\Subquestion::QUESTION_TYPE_COLOR_SELECT,$this->sessionSection->respondent->id_respondent);

        $subquestion->correct = $values->id_pages === $values->id_page;
        $subquestion->answer = $values->id_pages;

        $this->subquestion_service->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }

        $this->redirect("Survey:question");
        exit;
    }

    /**
     * @param Form $form
     */
    public function finalFormSubmitted(Form $form){
        $this->setView("results");
    }

    /** COMPONENTS */

    /**
     * @return Form
     */
    public function createComponentPersonalForm() {
        $form = (new PersonalForm($this,"personalForm"))->create();
        $form->onSuccess[] = $this->personalFormSubmitted;
        return $form;
    }

    /**
     * @return Form
     */
    public function createComponentColorForm() {
        $form = (new ColorForm($this,"colorForm"))->create($this->id_page, $this->id_question);
        $form->onSuccess[] = $this->colorFormSubmitted;
        return $form;
    }
    /**
     * @return Form
     */
    public function createComponentColorSelectForm() {
        $form = (new ColorSelectForm($this,"colorSelectForm"))->create($this->id_page, $this->id_question, $this->page_service->getRelatedPages($this->id_page));
        $form->onSuccess[] = $this->colorSelectFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeForm(){
        $form = (new WireframeForm($this,"wireframeForm"))->create($this->id_page, $this->id_wireframe, $this->id_question);
        $form->onSuccess[] = $this->wireframeFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeSelectForm(){
        $form = (new WireframeSelectForm($this,"wireframeSelectForm"))->create($this->id_page, $this->id_wireframe, $this->id_question, $this->page_service->getRelatedPages($this->id_page));
        $form->onSuccess[] = $this->wireframeSelectFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeReverseForm(){
        $form = (new WireframeReverse($this,"wireframeReverseForm"))->create($this->id_page, $this->id_wireframe, $this->id_question, $this->page_service->getRelatedPages($this->id_page));
        $form->onSuccess[] = $this->wireframeReverseFormSubmitted;
        return $form;
    }

    /**
     * @return Form
     */
    public function createComponentFinalForm(){
        $form = (new FinalForm())->create($this->website_service->getAll());
        $form->onSuccess[] = $this->finalFormSubmitted;
        return $form;
    }
}