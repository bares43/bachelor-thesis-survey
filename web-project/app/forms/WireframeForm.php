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
    private $name;

    /**
     * WireframeForm constructor.
     * @param $parent
     * @param $name
     */
    public function __construct($parent, $name) {
        $this->parent = $parent;
        $this->name = $name;
    }

    /**
     * @param int $id_page
     * @param int $id_wireframe
     * @param int|null $id_question
     * @return BaseSurveyForm
     */
    public function create($id_page, $id_wireframe, $id_question) {
        $form = new BaseSurveyForm($this->parent, $this->name);

        $form->addTextArea("answer","Název stránky");

        $form->addNavigation($id_page, $id_wireframe, $id_question);

        return $form;
    }
}