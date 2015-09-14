<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 9:35
 */

namespace App\Forms;


use App\Model\Page;

class WireframeReverse {

    /**
     * @param int $id_wireframe
     * @param int|null $id_question
     * @param Page[] $pages
     * @return BaseSurveyForm
     */
    public function create($id_wireframe, $id_question, $pages){
        $pages_select = array();
        foreach($pages as $page){
            $pages_select[$page->id_page] = $page->name;
        }

        $form = new BaseSurveyForm();

        $form->addRadioList('id_page','Který obrázek?',$pages_select)->setAttribute("class","buttons-group");

        $form->addNavigation($id_wireframe, $id_question);

        return $form;
    }
}