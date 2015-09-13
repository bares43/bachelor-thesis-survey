<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 26. 8. 2015
 * Time: 22:14
 */

namespace App\Forms;

use App\Model\Website;

class ColorSelectForm {

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