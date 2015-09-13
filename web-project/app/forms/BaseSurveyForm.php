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

    public function addNavigation(){
        $this->getElementPrototype()->addAttributes(['class'=>'center']);
        $this->addHidden('id_wireframe');
        $this->addHidden('id_question');
        $this->addTextArea("reason","Proč si to myslíte?");
//        $this->addSubmit("dontknow","Nemám tušení")->setAttribute("class","btn btn-xs");
        $this->addSubmit("continue","Pokračovat v dotazníku")->setAttribute("class","btn btn-primary");
        $this->addSubmit("cancel","Ukončit dotazník")->setAttribute("class","btn btn-xs");
    }

    public function render(){
        $params = func_get_arg(0);

        if(array_key_exists("defaults",$params))$this->setDefaults($params["defaults"]);

        if(array_key_exists("items", $params)){
            foreach($params["items"] as $name=>$items){
                $this->getComponent($name)->setItems($items);
            }
        }


        parent::render();
    }

}