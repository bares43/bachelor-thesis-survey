<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 9:22
 */

namespace App\Forms;


use App\Model\Website;

class WireframeSelectForm {

    /**
     * @return BaseSurveyForm
     */
    public function create(){

        $form = new BaseSurveyForm();

        $form->addRadioList("id_page","Název stránky")->setAttribute("class","buttons-group");

        $form->addNavigation();

        return $form;
    }
}