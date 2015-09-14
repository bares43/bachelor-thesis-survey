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
     * @param int $id_wireframe
     * @param int|null $id_question
     * @return BaseSurveyForm
     */
    public function create($id_wireframe, $id_question){
        $form = new BaseSurveyForm();

        $form->addTextArea("answer","Stránka");

        $form->addNavigation($id_wireframe, $id_question);

        return $form;
    }
}