<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 26. 8. 2015
 * Time: 21:45
 */

namespace App\Forms;

class ColorForm {

    /**
     * @return BaseSurveyForm
     */
    public function create(){
        $form = new BaseSurveyForm();

        $form->addTextArea("answer","Stránka");

        $form->addNavigation();

        return $form;
    }
}