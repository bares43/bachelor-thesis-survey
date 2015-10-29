<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 8:43
 */

namespace App\Forms;


class WireframeForm {

    private $parent;

    /**
     * WireframeForm constructor.
     * @param $parent
     */
    public function __construct($parent) {
        $this->parent = $parent;
    }

    /**
     * @param int $id_subquestion
     * @return BaseSurveyForm
     */
    public function create($id_subquestion) {
        $form = new BaseSurveyForm(/*$this->parent, "wireframeForm"*/);

        $form->addTextArea("answer","Název stránky");

        $form->addNavigation($id_subquestion);

        return $form;
    }
}