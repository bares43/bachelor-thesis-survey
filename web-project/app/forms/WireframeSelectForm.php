<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 9:22
 */

namespace App\Forms;


class WireframeSelectForm {

    /**
     * @param Website[] $websites
     * @return BaseSurveyForm
     */
    public function create($websites){

        $websites_select = array();
        foreach($websites as $website){
            $websites_select[$website->id_website] = $website->name;
        }

        $form = new BaseSurveyForm();

        $form->addRadioList("page","Název stránky",$websites_select)->setAttribute("class","buttons-group");

        $form->addNavigation();

        return $form;
    }
}