<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 8:43
 */

namespace App\Forms;


class WireframeForm {

    public function create() {
        $form = new BaseSurveyForm();

        $form->addTextArea("page","Název stránky");

        $form->addNavigation();

        return $form;
    }
}