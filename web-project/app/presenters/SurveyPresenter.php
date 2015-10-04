<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 21:19
 */

namespace App\Presenters;

use App\Forms\ColorForm;
use App\Forms\ColorSelectForm;
use App\Forms\FinalForm;
use App\Forms\PersonalForm;
use App\Forms\WireframeForm;
use App\Forms\WireframeReverse;
use App\Forms\WireframeSelectForm;
use App\Holder\NewQuestion;
use App\Service\Category;
use App\Service\EntityCategory;
use App\Service\Page;
use App\Service\Question;
use App\Service\Respondent;
use App\Service\RespondentWebsite;
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

    /** @var Category @inject */
    public $category_service;

    /** @var EntityCategory @inject */
    public $entity_category_service;

    /** @var RespondentWebsite @inject */
    public $respondent_website_service;

    /** @var Nette\Http\SessionSection */
    private $sessionSection;

    /** @var int */
    private $id_question;

    /** @var int */
    private $id_page;

    /** @var int */
    private $id_wireframe;

    /** @var \App\Holder\Page */
    private $page_holder;

    /** @var NewQuestion */
    private $new_question_holder;

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
        $new_question = $this->question_service->generateNewQuestion($this->sessionSection->respondent);

        $this->new_question_holder = $new_question;
        $this->setView($new_question->getQuestionType());
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
    private function setHelp() {
        if($this->new_question_holder->getPageHolder()->getCurrentWireframe()->text_mode === \App\Model\Wireframe::TEXT_BOX) $this->template->help_gray = true;
        if($this->new_question_holder->getPageHolder()->getCurrentWireframe()->text_mode === \App\Model\Wireframe::TEXT_LOREM) $this->template->help_lorem = true;
        if($this->new_question_holder->getPageHolder()->getCurrentWireframe()->text_mode === \App\Model\Wireframe::IMAGE_BLUR) $this->template->help_blur = true;
        if($this->new_question_holder->getPageHolder()->getCurrentWireframe()->text_mode === \App\Model\Wireframe::IMAGE_BOX) $this->template->help_box = true;
    }

    public function renderWireframe(){
        $this->template->answer_btn = "#frm-wireframeForm-page";
        $this->setHelp();
        $this->template->id_wireframe = $this->new_question_holder->getPageHolder()->getCurrentWireframe()->id_wireframe;
        $this->template->form = $this->createComponentWireframeForm();
    }

    public function renderWireframeselect(){
        $this->template->answer_btn = "#frm-wireframeForm-page";
        $this->setHelp();
        $this->template->id_wireframe = $this->new_question_holder->getPageHolder()->getCurrentWireframe()->id_wireframe;
        $this->template->form = $this->createComponentWireframeSelectForm();
    }

    public function renderWireframereverse(){
        $this->setHelp();
        $this->template->page = $this->new_question_holder->getPageHolder();
        $this->template->pages_holders = $this->new_question_holder->getPagesHolders();
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
        $respondent->it = $values->it === 1;
        if(is_array($values->device)){
            $respondent->device_phone = in_array(\App\Model\Respondent::DEVICE_PHONE, $values->device);
            $respondent->device_tablet = in_array(\App\Model\Respondent::DEVICE_TABLET, $values->device);
            $respondent->device_computer = in_array(\App\Model\Respondent::DEVICE_COMPUTER, $values->device);
        }
        $respondent->device_most = $values->device_most;
        $respondent->email = $values->email;
        $respondent->message = $values->message;
        $respondent->sites = $values->sites;
        $respondent->user_agent = $_SERVER["HTTP_USER_AGENT"];
        $respondent->code = $values->code;
        $this->respondent_service->save($respondent);

        foreach($values->category as $category_id => $params){
            $period = $params["period"];
            if($period !== null){
                $this->entity_category_service->addCategoryToRespondent($category_id, $respondent->id_respondent, $period);

                if(array_key_exists("items",$params)){
                    foreach($params->items as $item){
                        $this->entity_category_service->addCategoryToRespondent($item, $respondent->id_respondent, \App\Model\EntityCategory::MOSTLY);
                    }
                }
            }
        }

        $this->sessionSection->next_personal = false;
        $this->sessionSection->respondent = $respondent;
        $this->sessionSection->code = null;

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
        // rekonstrukce puvodnich id_pages
        $values = $form->getValues();
        $id_page = $values->id_page;
        $pages = $this->page_service->getRelatedPages($id_page);
        $options = array($id_page=>"",$pages[0]->id_page);

        $form->getComponent("id_pages")->setItems($options);

        $values = $form->getValues();

        $subquestion = $this->subquestion_service->prepareSubquestionForSave($values, \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_SELECT,$this->sessionSection->respondent->id_respondent);

        $subquestion->correct = $values->id_pages === (int)$values->id_page;
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
        // rekonstrukce puvodnich id_pages
        $values = $form->getValues();
        $id_page = $values->id_page;
        $pages = $this->page_service->getRelatedPages($id_page);
        $options = array(0=>"",$id_page=>"",$pages[0]->id_page);

        $form->getComponent("id_pages")->setItems($options);

        $values = $form->getValues();

        $subquestion = $this->subquestion_service->prepareSubquestionForSave($values, \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE,$this->sessionSection->respondent->id_respondent);

        $subquestion->correct = $values->id_pages === (int)$values->id_page;
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
        // rekonstrukce puvodnich id_pages
        $values = $form->getValues();
        $id_page = $values->id_page;
        $pages = $this->page_service->getRelatedPages($id_page);
        $options = array($id_page=>"",$pages[0]->id_page);

        $form->getComponent("id_pages")->setItems($options);

        $values = $form->getValues();

        $subquestion = $this->subquestion_service->prepareSubquestionForSave($values, \App\Model\Subquestion::QUESTION_TYPE_COLOR_SELECT,$this->sessionSection->respondent->id_respondent);

        $subquestion->correct = $values->id_pages === (int)$values->id_page;
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
        $values = $form->getValues();

        foreach($values->website as $id_website => $param){
            $period = $param["period"];

            if($period !== null){
                $this->respondent_website_service->addWebsiteToRespondent($id_website, $this->sessionSection->respondent->id_respondent, $period);
            }
        }

        $this->setView("results");


    }

    /** COMPONENTS */

    /**
     * @return Form
     */
    public function createComponentPersonalForm() {
        $code = $this->sessionSection->code;
        $form = (new PersonalForm($this,"personalForm"))->create($this->category_service->getCategoriesHolders(),$code);
        $form->onSuccess[] = $this->personalFormSubmitted;
        return $form;
    }

    /**
     * @return Form
     */
    public function createComponentColorForm() {
        $form = (new ColorForm($this))->create(
            $this->new_question_holder->getPageHolder()->getPage()->id_page,
            $this->new_question_holder->getQuestionId()
        );
        $form->onSuccess[] = $this->colorFormSubmitted;
        return $form;
    }
    /**
     * @return Form
     */
    public function createComponentColorSelectForm() {
        $form = (new ColorSelectForm($this))->create(
            $this->new_question_holder->getPageHolder()->getPage()->id_page,
            $this->new_question_holder->getQuestionId(),
            $this->new_question_holder->getPagesHolders()
        );
        $form->onSuccess[] = $this->colorSelectFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeForm(){
        $form = (new WireframeForm($this))->create(
            $this->new_question_holder->getPageHolder()->getPage()->id_page,
            $this->new_question_holder->getPageHolder()->getCurrentWireframe()->id_wireframe,
            $this->new_question_holder->getQuestionId()
        );
        $form->onSuccess[] = $this->wireframeFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeSelectForm(){
        $form = (new WireframeSelectForm($this))->create(
            $this->new_question_holder->getPageHolder()->getPage()->id_page,
            $this->new_question_holder->getPageHolder()->getCurrentWireframe()->id_wireframe,
            $this->new_question_holder->getQuestionId(),
            $this->new_question_holder->getPagesHolders());
        $form->onSuccess[] = $this->wireframeSelectFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeReverseForm(){
        $form = (new WireframeReverse($this))->create(
            $this->new_question_holder->getPageHolder()->getPage()->id_page,
            $this->new_question_holder->getPageHolder()->getCurrentWireframe()->id_wireframe,
            $this->new_question_holder->getQuestionId(),
            $this->new_question_holder->getPagesHolders()
        );
        $form->onSuccess[] = $this->wireframeReverseFormSubmitted;
        return $form;
    }

    /**
     * @return Form
     */
    public function createComponentFinalForm(){
        $websites = array();
        $subquestions = $this->question_service->getSubquestionHoldersByIdRespondent($this->sessionSection->respondent->id_respondent);
        foreach($subquestions as $subquestion){
            $websites[$subquestion->getWebsite()->id_website] = $subquestion->getWebsite()->name;
        }

        $form = (new FinalForm($this))->create($websites);
        $form->onSuccess[] = $this->finalFormSubmitted;
        return $form;
    }
}