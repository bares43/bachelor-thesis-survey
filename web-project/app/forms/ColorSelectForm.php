<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 26. 8. 2015
 * Time: 22:14
 */

namespace App\Forms;

use App\Model\Page;

class ColorSelectForm {

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
     * @param Page[] $pages
     * @return BaseSurveyForm
     */
    public function create($id_page, $id_question, $pages){
        $pages_select = array();
        foreach($pages as $page){
            $pages_select[$page->id_page] = $page->name;
        }

        $form = new BaseSurveyForm($this->parent, $this->name);

        $form->addRadioList("id_pages","Název stránky",$pages_select)->setAttribute("class","buttons-group");

        $form->addNavigation($id_page, null, $id_question);

        return $form;
    }
}