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