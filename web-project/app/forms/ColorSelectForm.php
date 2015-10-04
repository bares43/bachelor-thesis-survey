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

    /**
     * WireframeForm constructor.
     * @param $parent
     */
    public function __construct($parent) {
        $this->parent = $parent;
    }

    /**
     * @param int $id_page
     * @param int|null $id_question
     * @param \App\Holder\Page[] $pages
     * @return BaseSurveyForm
     */
    public function create($id_page, $id_question, $pages){
        $pages_select = array();
        foreach($pages as $page){
            $pages_select[$page->getPage()->id_page] = $page->getWebsite()->name;
        }

        $form = new BaseSurveyForm($this->parent, "colorSelectForm");

        $form->addRadioList("id_pages","Název stránky",$pages_select)->setAttribute("class","buttons-group");

        $form->addNavigation($id_page, null, $id_question);

        return $form;
    }
}