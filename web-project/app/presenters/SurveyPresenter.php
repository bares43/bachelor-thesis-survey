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
    }

    /**
     * ACTION
     */

    public function actionQuestion() {
        $this->new_question_holder = new NewQuestion();
        $this->new_question_holder->setPageHolder(new \App\Holder\Page());
        $this->new_question_holder->setQuestion(new \App\Model\Question());
        $this->new_question_holder->setSubquestion(new \App\Model\Subquestion());
        $this->new_question_holder->setPagesHolders(array());
        $this->new_question_holder->setQuestionType(0);
    }

    public function actionDefault(){
        if($this->sessionSection->cannot_continue){
            $this->redirect("Survey:noQuestions");
        }
        $this->redirect("Survey:personal");
    }

    public function actionPersonal(){
        if($this->sessionSection->cannot_continue){
            $this->redirect("Survey:noQuestions");
        }

        if($this->sessionSection->id_respondent !== null){
            $this->setView("continue");
        }
    }

    public function actionNewRespondent(){
        $this->sessionSection->id_respondent = null;
        $this->sessionSection->cannot_continue = false;
        $this->redirect("Survey:personal");
    }

    public function actionResults() {
        if($this->sessionSection->id_respondent === null) {
            $this->redirect("Survey:personal");
        }
    }

    public function actionFinal() {
        if($this->sessionSection->id_respondent === null) {
            $this->redirect("Survey:personal");
        }
        if($this->sessionSection->cannot_final){
            $this->redirect("Survey:results");
        }
    }

    /**
     * RENDER
     */

    public function renderQuestion(){
        $respondent = null;
        if($this->sessionSection->id_respondent !== null){
            $respondent = $this->respondent_service->get($this->sessionSection->id_respondent);
        }
        $new_question = $this->question_service->generateNewQuestion($respondent);

        if($new_question === null) {
            $this->sessionSection->cannot_continue = true;
            $this->redirect("Survey:final");
        }

        $this->sessionSection->cannot_final = false;

        $this->new_question_holder = $new_question;

        switch($new_question->getQuestionType()){
            case \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME:
            case \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_SELECT:
                $this->template->id_wireframe = $this->new_question_holder->getPageHolder()->getCurrentWireframe()->id_wireframe;
                $this->template->id_wireframe = $this->new_question_holder->getPageHolder()->getCurrentWireframe()->id_wireframe;
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE:
                $this->template->page = $this->new_question_holder->getPageHolder();
                $this->template->pages_holders = $this->new_question_holder->getPagesHolders();
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_COLOR:
            case \App\Model\Subquestion::QUESTION_TYPE_COLOR_SELECT:
                $this->template->color = $this->new_question_holder->getPageHolder()->getPage()->dominant_color;
                $this->template->help_lorem = true;
                break;
        }


        if($this->new_question_holder->getPageHolder()->getCurrentWireframe()->text_mode === \App\Model\Wireframe::TEXT_BOX) $this->template->help_gray = true;
        if($this->new_question_holder->getPageHolder()->getCurrentWireframe()->text_mode === \App\Model\Wireframe::TEXT_LOREM) $this->template->help_lorem = true;
        if($this->new_question_holder->getPageHolder()->getCurrentWireframe()->text_mode === \App\Model\Wireframe::IMAGE_BLUR) $this->template->help_blur = true;
        if($this->new_question_holder->getPageHolder()->getCurrentWireframe()->text_mode === \App\Model\Wireframe::IMAGE_BOX) $this->template->help_box = true;

//        $this->setView($new_question->getQuestionType());
//   echo $this->subquestion_service->questionTypeToString($new_question->getQuestionType());exit;
//echo "tst";exit;
        $this->template->type = $this->subquestion_service->questionTypeToString($new_question->getQuestionType());
        $this->template->showAppeal = true;
        $this->template->respondent_subquestions_count = $new_question->getRespondentSubquestionsCount();
        $this->template->max_questions_for_respondent_reached = $new_question->getRespondentSubquestionsCount() >= $this->context->getParameters()["max_questions_for_respondent"];
    }

//    public function renderWireframe(){
//        $this->template->answer_btn = "#frm-wireframeForm-page";
//        $this->template->showAppeal = true;
//        $this->setHelp();
//        $this->template->id_wireframe = $this->new_question_holder->getPageHolder()->getCurrentWireframe()->id_wireframe;
//    }
//
//    public function renderWireframeselect(){
//        $this->template->answer_btn = "#frm-wireframeForm-page";
//        $this->template->showAppeal = true;
//        $this->setHelp();
//        $this->template->id_wireframe = $this->new_question_holder->getPageHolder()->getCurrentWireframe()->id_wireframe;
//    }
//
//    public function renderWireframereverse(){
//        $this->setHelp();
//        $this->template->showAppeal = true;
//        $this->template->page = $this->new_question_holder->getPageHolder();
//        $this->template->pages_holders = $this->new_question_holder->getPagesHolders();
//    }
//
//    public function renderColor(){
//        $this->template->showAppeal = true;
//        $this->template->color = "3397C7";
//        $this->template->answer_btn = "#frm-colorForm-answer";
//        $this->template->help_lorem = true;
//    }
//
//    public function renderColorselect(){
//        $this->template->showAppeal = true;
//        $this->template->color = "3397C7";
//        $this->template->help_lorem = true;
//    }

    public function renderFinal(){
        $this->template->form = $this->createComponentFinalForm();
    }

    public function renderResults() {

        $respondent = $this->respondent_service->get($this->sessionSection->id_respondent);
        $subquestions = $this->question_service->getSubquestionHoldersByIdRespondent($respondent->id_respondent);

        $pages = array();
        $total_correct = 0;
        $total_wrong = 0;
        $total_not_evaluated = 0;

        foreach($subquestions as $subquestion){
            if($subquestion->getSubquestion()->correct){
                $total_correct++;
            }
            elseif($subquestion->getSubquestion()->correct === null){
                $total_not_evaluated++;
            }else{
                $total_wrong++;
            }
            $pages[] = $subquestion->getPage()->id_page;
        }

        $pages = array_unique($pages);

        $this->template->total_questions = count($subquestions);
        $this->template->total_pages = count($pages);
        $this->template->total_correct = $total_correct;
        $this->template->total_wrong = $total_wrong;
        $this->template->total_not_evaluated = $total_not_evaluated;
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
        if(isset($values->code))$respondent->code = $values->code;
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

        $this->sessionSection->id_respondent = $respondent->id_respondent;
        $this->sessionSection->code = null;
        $this->sessionSection->cannot_final = false;

        if($this->sessionSection->id_question !== null){
            $question = $this->question_service->get($this->sessionSection->id_question);
            $question->id_respondent = $respondent->id_respondent;
            $this->question_service->save($question);
        }

        $this->redirect("Survey:question");
    }

    /**
     * @param Form $form
     */
    public function wireframeFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->subquestion_service->saveBaseProperties($values);

        $subquestion->answer = $values->answer;

        $this->subquestion_service->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }

        if($this->sessionSection->id_respondent === null){
            $this->sessionSection->id_question = $subquestion->id_question;
            $this->redirect("Survey:personal");
        }else{
            $this->redirect("Survey:question");
        }
    }

    /**
     * @param Form $form
     */
    public function wireframeSelectFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->subquestion_service->saveBaseProperties($values);

        // rekonstrukce puvodnich id_pages
        $id_page = $this->question_service->get($subquestion->id_question)->id_page;
        $pages = $this->page_service->getRelatedPages($id_page);
        $options = array($id_page=>"",$pages[0]->id_page);

        $form->getComponent("id_pages")->setItems($options);

        $values = $form->getValues();

        $subquestion->correct = $values->id_pages === (int)$id_page;
        $subquestion->answer = $values->id_pages;

        $this->subquestion_service->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }

        if($this->sessionSection->id_respondent === null){
            $this->sessionSection->id_question = $subquestion->id_question;
            $this->redirect("Survey:personal");
        }else{
            $this->redirect("Survey:question");
        }
    }

    /**
     * @param Form $form
     */
    public function wireframeReverseFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->subquestion_service->saveBaseProperties($values);

        // rekonstrukce puvodnich id_pages
        $id_page = $this->question_service->get($subquestion->id_question)->id_page;
        $pages = $this->page_service->getRelatedPages($id_page);
        $options = array(0=>"",$id_page=>"",$pages[0]->id_page);

        $form->getComponent("id_pages")->setItems($options);

        $values = $form->getValues();

        $subquestion->correct = $values->id_pages === (int)$id_page;
        $subquestion->answer = $values->id_pages;

        $this->subquestion_service->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }

        if($this->sessionSection->id_respondent === null){
            $this->sessionSection->id_question = $subquestion->id_question;
            $this->redirect("Survey:personal");
        }else{
            $this->redirect("Survey:question");
        }
    }

    /**
     * @param Form $form
     */
    public function colorFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->subquestion_service->saveBaseProperties($values);

        $subquestion->answer = $values->answer;

        $this->subquestion_service->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }

        if($this->sessionSection->id_respondent === null){
            $this->sessionSection->id_question = $subquestion->id_question;
            $this->redirect("Survey:personal");
        }else{
            $this->redirect("Survey:question");
        }
    }

    /**
     * @param Form $form
     */
    public function colorSelectFormSubmitted(Form $form){
        $values = $form->getValues();

        $subquestion = $this->subquestion_service->saveBaseProperties($values);

        // rekonstrukce puvodnich id_pages
        $id_page = $this->question_service->get($subquestion->id_question)->id_page;
        $pages = $this->page_service->getRelatedPages($id_page);
        $options = array($id_page=>"",$pages[0]->id_page);

        $form->getComponent("id_pages")->setItems($options);

        $values = $form->getValues();

        $subquestion->correct = $values->id_pages === (int)$id_page;
        $subquestion->answer = $values->id_pages;

        $this->subquestion_service->save($subquestion);

        if($form['cancel']->isSubmittedBy()){
            $this->redirect("Survey:final");
        }

        if($this->sessionSection->id_respondent === null){
            $this->sessionSection->id_question = $subquestion->id_question;
            $this->redirect("Survey:personal");
        }else{
            $this->redirect("Survey:question");
        }
    }

    /**
     * @param Form $form
     */
    public function finalFormSubmitted(Form $form){
        $values = $form->getValues();

        foreach($values->website as $id_website => $param){
            $period = $param["period"];

            if($period !== null){
                $this->respondent_website_service->addWebsiteToRespondent($id_website, $this->sessionSection->id_respondent, $period);
            }
        }


        $this->sessionSection->cannot_final = true;

        $this->redirect("Survey:results");
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
            $this->new_question_holder->getSubquestion()->id_subquestion
        );
        $form->onSuccess[] = $this->colorFormSubmitted;
        return $form;
    }
    /**
     * @return Form
     */
    public function createComponentColorSelectForm() {
        $form = (new ColorSelectForm($this))->create(
            $this->new_question_holder->getSubquestion()->id_subquestion,
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
            $this->new_question_holder->getSubquestion()->id_subquestion
        );
        $form->onSuccess[] = $this->wireframeFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeSelectForm(){
        $form = (new WireframeSelectForm($this))->create(
            $this->new_question_holder->getSubquestion()->id_subquestion,
            $this->new_question_holder->getPagesHolders());
        $form->onSuccess[] = $this->wireframeSelectFormSubmitted;
        return $form;
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeReverseForm(){
        $form = (new WireframeReverse($this))->create(
            $this->new_question_holder->getSubquestion()->id_subquestion,
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
        $subquestions = $this->question_service->getSubquestionHoldersByIdRespondent($this->sessionSection->id_respondent);
        foreach($subquestions as $subquestion){
            $websites[$subquestion->getWebsite()->id_website] = $subquestion->getWebsite()->name;
        }

        $form = (new FinalForm($this))->create($websites);
        $form->onSuccess[] = $this->finalFormSubmitted;
        return $form;
    }
}