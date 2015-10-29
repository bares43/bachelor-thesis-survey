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
     * @param int $id_subquestion
     */
    public function addNavigation($id_subquestion){
        $this->getElementPrototype()->addAttributes(['class'=>'center']);
        $this->addHidden('id_subquestion',$id_subquestion);
        $this->addHidden('seconds',0);
        $this->addTextArea("reason","Proč si to myslíte?");
        $this->addSubmit("continue","Pokračovat v dotazníku")->setAttribute("class","btn btn-primary");
        $this->addSubmit("cancel","Ukončit dotazník")->setAttribute("class","btn btn-xs");
    }

}