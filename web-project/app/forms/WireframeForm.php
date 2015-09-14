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
     * @param int $id_wireframe
     * @param int|null $id_question
     * @return BaseSurveyForm
     */
    public function create($id_wireframe, $id_question) {
        $form = new BaseSurveyForm();

        $form->addTextArea("answer","Název stránky");

        $form->addNavigation($id_wireframe, $id_question);

        return $form;
    }
}