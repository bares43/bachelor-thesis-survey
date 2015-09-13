<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 9:35
 */

namespace App\Forms;


class WireframeReverse {

    /**
     * @return BaseSurveyForm
     */
    public function create(){
        $form = new BaseSurveyForm();

        $form->addRadioList('id_page','Který obrázek?')->setAttribute("class","buttons-group");

        $form->addNavigation();

        return $form;
    }
}