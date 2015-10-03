<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 9:22
 */

namespace App\Forms;


use App\Model\Page;

class WireframeSelectForm {

    private $parent;

    /**
     * WireframeForm constructor.
     * @param $parent
     */
    public function __construct($parent) {
        $this->parent = $parent;
    }

    /**
     * @param int $id_page
     * @param int $id_wireframe
     * @param int|null $id_question
     * @param \App\Holder\Page[] $pages
     * @return BaseSurveyForm
     */
    public function create($id_page, $id_wireframe, $id_question, $pages){
        $pages_select = array();
//        foreach($pages as $page){
//            $pages_select[$page->id_page] = $page->name;
//        }

        $form = new BaseSurveyForm($this->parent, "wireframeSelectForm");

        $form->addRadioList("id_pages","Název stránky",$pages_select)->setAttribute("class","buttons-group");

        $form->addNavigation($id_page, $id_wireframe, $id_question);

        return $form;
    }
}