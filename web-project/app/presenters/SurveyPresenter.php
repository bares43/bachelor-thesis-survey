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
use App\Forms\PersonalForm;
use App\Forms\WireframeForm;
use App\Forms\WireframeReverse;
use App\Forms\WireframeSelectForm;
use App\Service\Websites;
use Nette;
use Nette\Application\UI\Form;

class SurveyPresenter extends Nette\Application\UI\Presenter {

    /** @var Websites @inject */
    public $websites;

    /**
     * @return Form
     */
    public function createComponentPersonalForm() {
        return (new PersonalForm())->create();
    }

    /**
     * @return Form
     */
    public function createComponentColorForm() {
        return (new ColorForm())->create();
    }
    /**
     * @return Form
     */
    public function createComponentColorSelectForm() {
        return (new ColorSelectForm())->create($this->websites->getAll());
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeForm(){
        return (new WireframeForm())->create();
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeSelectForm(){
        return (new WireframeSelectForm())->create($this->websites->getAll());
    }

    /**
     * @return \App\Forms\BaseSurveyForm
     */
    public function createComponentWireframeReverseForm(){
        return (new WireframeReverse())->create();
    }

    public function actionDefault(){
        $this->setView("personal");
    }

    public function actionPersonal(){
    }

    public function renderPesonal(){

    }

    public function renderColor(){
        $this->template->color = "3397C7";
        $this->template->answer_btn = "#frm-colorForm-answer";
        $this->template->help_lorem = true;
    }

    public function renderColorselect(){
        $this->template->color = "3397C7";
        $this->template->help_lorem = true;
    }

    public function renderWireframe(){
        $this->template->answer_btn = "#frm-wireframeForm-page";
        $this->template->help_lorem = true;
        $this->template->help_gray = true;
        $this->template->help_blur = true;
    }

    public function renderWireframeselect(){
        $this->template->answer_btn = "#frm-wireframeForm-page";
        $this->template->help_lorem = true;
        $this->template->help_gray = true;
        $this->template->help_blur = true;
    }

    public function renderWireframereverse(){
//        $this->template->answer_btn = "#frm-wireframeForm-page";
        $this->template->help_lorem = true;
        $this->template->help_gray = true;
//        $this->template->help_blur = true;
    }

}