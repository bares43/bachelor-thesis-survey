<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 9:35
 */

namespace App\Forms;


use App\Holder\PageRelated;

class WireframeReverse {

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
     * @param PageRelated $related
     * @return BaseSurveyForm
     */
    public function create($id_subquestion, $related){
        $pages_select = array();

        if($related !== null && count($related->getPagesRelatedAsArray()) === 2){
            $related_array = $related->getPagesRelatedAsArray();
            if($related_array[0] !== null && $related_array[1] !== null){
                $pages_select[$related_array[0]->getPage()->id_page] = "první";
                $pages_select[0] = "nevím";
                $pages_select[$related_array[1]->getPage()->id_page] = "druhý";
            }
        }

        $form = new BaseSurveyForm(/*$this->parent, "wireframeReverseForm"*/);

        $form->addRadioList('id_pages','Který obrázek?',$pages_select)->setAttribute("class","buttons-group");

        $form->addNavigation($id_subquestion);

        return $form;
    }
}