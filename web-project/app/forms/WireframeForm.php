<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 8:43
 */

namespace App\Forms;


class WireframeForm {

    /**
     * @return BaseSurveyForm
     */
    public function create() {
        $form = new BaseSurveyForm();

        $form->addTextArea("answer","Název stránky");

        $form->addNavigation();

        return $form;
    }
}