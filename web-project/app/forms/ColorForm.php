<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 26. 8. 2015
 * Time: 21:45
 */

namespace App\Forms;

class ColorForm {

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
     * @param int|null $id_question
     * @return BaseSurveyForm
     */
    public function create($id_page, $id_question){
        $form = new BaseSurveyForm($this->parent, $this->name);

        $form->addTextArea("answer","Stránka");

        $form->addNavigation($id_page, null, $id_question);

        return $form;
    }
}