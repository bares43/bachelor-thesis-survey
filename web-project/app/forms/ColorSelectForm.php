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

    /**
     * @param int $id_wireframe
     * @param intwnull $id_question
     * @param Page[] $pages
     * @return BaseSurveyForm
     */
    public function create($id_wireframe, $id_question, $pages){
        $pages_select = array();
        foreach($pages as $page){
            $pages_select[$page->id_page] = $page->name;
        }

        $form = new BaseSurveyForm();

        $form->addRadioList("id_page","Název stránky",$pages_select)->setAttribute("class","buttons-group");

        $form->addNavigation($id_wireframe, $id_question);

        return $form;
    }
}