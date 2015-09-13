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
use App\Model\Respondent;
use App\Model\Subquestion;
use App\Service\Pages;
use App\Service\Questions;
use App\Service\Respondents;
use App\Service\Subquestions;
use App\Service\Websites;
use App\Service\Wireframes;
use Nette;
use Nette\Application\UI\Form;

class SurveyPresenter extends Nette\Application\UI\Presenter {

    /** @var Websites @inject */
    public $websites;

    /** @var  Pages @inject */
    public $pages;

    /** @var  Respondents @inject */
    public $respondents;

    /** @var  Questions @inject */
    public $questions;

    /** @var  Subquestions @inject */
    public $subquestions;

    /** @var  Wireframes @inject */
    public $wireframes;

    /** @var  Nette\Http\SessionSection */
    private $sessionSection;

    protected function startup() {
        parent::startup();

        $this->sessionSection = $this->getSession()->getSection("survey");

        if($this->sessionSection->next_personal && $this->sessionSection->id_respondent === null && $this->action !== "personal"){
            $this->redirect("Survey:personal");
            exit;
        }

        if($this->sessionSection->id_respondent === null){
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
        $options = array("wireframe","wireframeselect","wireframereverse");
        $view = $options[array_rand($options)];
        $this->setView($view);
    }

    public function actionPersonal(){
        if($this->sessionSection->id_respondent !== null){
            $this->setView("continue");
        }
    }

    public function actionNewRespondent(){
        $this->sessionSection->id_respondent = null;
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
        $this->template->form_params = array(
          "defaults" => array(
              "id_wireframe"=>1,
              "id_question"=>null
          )
        );
    }

    public function renderWireframeselect(){
        $this->template->answer_btn = "#frm-wireframeForm-page";
        $this->template->help_lorem = true;
        $this->template->help_gray = true;
        $this->template->help_blur = true;

        $pages_select = array();
        foreach($this->pages->getAll() as $page){
            $pages_select[$page->id_page] = $page->name;
        }
        $this->template->pages = $pages_select;


        $this->template->form_params = array(
            "defaults" => array(
                "id_wireframe"=>1,
                "id_question"=>null
            ),
            "items" => array(
                "id_page"=>$pages_select
            )
        );
    }

    public function renderWireframereverse(){
        $this->template->help_lorem = true;
        $this->template->help_gray = true;
        $this->template->form_params = array(
            "defaults" => array(
                "id_wireframe"=>1,
                "id_question"=>null
            )
        );
    }

    public function renderColor(){
        $this->template->color = "3397C7";
        $this->template->answer_btn = "#frm-colorForm-answer";
        $this->template->help_lorem = true;
        $this->template->form_params = array(
            "defaults" => array(
                "id_wireframe"=>1,
                "id_question"=>null
            )
        );
    }

    public function renderColorselect(){
        $this->template->color = "3397C7";
        $this->template->help_lorem = true;

        $pages_select = array();
        foreach($this->pages->getAll() as $page){
            $pages_select[$page->id_page] = $page->name;
        }

        $this->template->form_params = array(
            "defaults" => array(
                "id_wireframe"=>1,
                "id_question"=>null
            ),
            "items" => array(
                "id_page" => $pages_select
            )
        );
    }


    /** FORMS SUCCESS */

    /**
     * @param Form $form
     */
    public function personalFormSubmitted(Form $form){
        $values = $form->getValues();

        $respondent = new Respondent();
        $respondent->gender = $values->gender;
        $respondent->age = $values->age;
        $respondent->english = $values->english === 1;
        if(is_array($values->device)){
            $respondent->device_phone = in_array(Respondent::DEVICE_PHONE, $values->device);
            $respondent->device_tablet = in_array(Respondent::DEVICE_TABLET, $values->device);
            $respondent->device_computer = in_array(Respondent::DEVICE_COMPUTER, $values->device);
        }
        $respondent->device_most = $values->device_most;
        $respondent->email = $values->email;
        $respondent->message = $values->message;
        $respondent->sites = $values->sites;
        $this->respondents->save($respondent);

        $this->sessionSection->id_respondent = $respondent->id_respondent;
        $this->sessionSection->next_personal = false;

        $this->redirect("Survey:question");
    }

    /**
     * @param Form $form
     */
    public function wireframeFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->prepareSubquestionForSave($values, Subquestion::QUESTION_TYPE_WIREFRAME);

        $subquestion->answer = $values->answer;

        $this->subquestions->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }
    }

    /**
     * @param Form $form
     */
    public function wireframeSelectFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->prepareSubquestionForSave($values, Subquestion::QUESTION_TYPE_WIREFRAME_SELECT);

        $wireframe = $this->wireframes->get($values->id_wireframe);
        $subquestion->correct = $values->id_page === $wireframe->id_page;

        $this->subquestions->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }
    }

    /**
     * @param Form $form
     */
    public function wireframeReverseFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->prepareSubquestionForSave($values, Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE);

        $wireframe = $this->wireframes->get($values->id_wireframe);
        $subquestion->correct = $values->id_page === $wireframe->id_page;

        $this->subquestions->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }
    }

    /**
     * @param Form $form
     */
    public function colorFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->prepareSubquestionForSave($values, Subquestion::QUESTION_TYPE_COLOR);

        $subquestion->answer = $values->answer;

        $this->subquestions->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }
    }

    /**
     * @param Form $form
     */
    public function colorSelectFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->prepareSubquestionForSave($values, Subquestion::QUESTION_TYPE_COLOR_SELECT);

        $wireframe = $this->wireframes->get($values->id_wireframe);
        $subquestion->correct = $values->id_page === $wireframe->id_page;

        $this->subquestions->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }
    }

    /**
     * @param Form $form
     */
    public function finalFormSubmitted(Form $form){
        $this->setView("results");
    }

    /** MISC */

    /**
     * @param Nette\Utils\ArrayHash $values
     * @return int
     */
    private function getIdQuestion($values) {
        if($values->id_question != null) return $values->id_question;

        $id_page = $this->wireframes->get($values->id_wireframe)->id_page;

        $question = $this->questions->create($this->sessionSection->id_respondent, $id_page);
        return $question->id_question;
    }

    /**
     * @param Nette\Utils\ArrayHash $values
     * @param int $type
     * @return Subquestion
     */
    private function prepareSubquestionForSave($values, $type){
        $id_question = $this->getIdQuestion($values);

        $subquestion = new Subquestion();
        $subquestion->question_type = $type;
        $subquestion->id_question = $id_question;
        $subquestion->id_wireframe = $values->id_wireframe;
        $subquestion->reason = $values->reason;

        return $subquestion;
    }

    /** COMPONENTS */

    /**
     * @return Form
     */
    public function createComponentPersonalForm() {
        $form = (new PersonalForm())->create();
        $form->onSuccess[] = $this->personalFormSubmitted;
        return $form;
    }

    /**
     * @return Form
     */
    public function createComponentColorForm() {
        $form = (new ColorForm())->create();
        $form->onSuccess[] = $this->colorFormSubmitted;
        return $form;
    }
    /**
     * @return Form
     */
    public function createComponentColorSelectForm() {
        $form = (new ColorSelectForm())->create($this->websites->getAll());
        $form->onSuccess[] = $this->colorSelectFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeForm(){
        $form = (new WireframeForm())->create();
        $form->onSuccess[] = $this->wireframeFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeSelectForm(){
        $form = (new WireframeSelectForm())->create();
        $form->onSuccess[] = $this->wireframeSelectFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeReverseForm(){
        $form = (new WireframeReverse())->create();
        $form->onSuccess[] = $this->wireframeReverseFormSubmitted;
        return $form;
    }

    /**
     * @return Form
     */
    public function createComponentFinalForm(){
        $form = (new FinalForm())->create($this->websites->getAll());
        $form->onSuccess[] = $this->finalFormSubmitted;
        return $form;
    }
}