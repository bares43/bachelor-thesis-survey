<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 8:18
 */

namespace App\Forms;


use Nette\Application\UI\Form;
use Nette\Forms\Controls;

class BaseSurveyForm extends Form {

    /**
     * @param int $id_wireframe
     * @param int $id_question
     */
    public function addNavigation($id_wireframe, $id_question){
        $this->getElementPrototype()->addAttributes(['class'=>'center']);
        $this->addHidden('id_wireframe',$id_wireframe);
        $this->addHidden('id_question',$id_question);
        $this->addTextArea("reason","Proč si to myslíte?");
//        $this->addSubmit("dontknow","Nemám tušení")->setAttribute("class","btn btn-xs");
        $this->addSubmit("continue","Pokračovat v dotazníku")->setAttribute("class","btn btn-primary");
        $this->addSubmit("cancel","Ukončit dotazník")->setAttribute("class","btn btn-xs");
    }

}