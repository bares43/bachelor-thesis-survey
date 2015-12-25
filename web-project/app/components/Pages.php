<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 19. 12. 2015
 * Time: 17:01
 */

namespace App\Components;


use App\Service\Page;
use App\Utils\Filter;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Utils\Paginator;

class Pages extends FilterComponent{


    /**
     * @var Page
     */
    private $page_service;

    /**
     * @var \App\Filter\Results\Respondents
     */
    private $filter;

    /**
     * Subquestions constructor.
     * @param Page $page_service
     */
    public function __construct(Page $page_service) {
        parent::__construct();

        $this->filter = new \App\Filter\Results\Pages();

        $this->page_service = $page_service;
    }

    public function render() {
        $pages = $this->page_service->getResultsPages($this->filter);

        $template = $this->prepareTemplate();

        $template->pages = $pages;
        $template->count = count($pages);

        $template->render();
    }


    /**
     * @param Form $form
     */
    public function filterFormSubmited(Form $form) {
        $values = $form->getValues();

        if($values->id){
            $this->filter->setIdsPages(Filter::createFilterArray($values->id));
        }

        if($values->subquestions){
            $this->filter->setSubquestions(Filter::createFilterArray($values->subquestions));
        }

        if($values->correct){
            $this->filter->setCorrect(Filter::createFilterArray($values->correct));
        }

        if($values->percentages){
            $this->filter->setPercentages(Filter::createFilterArray($values->percentages));
        }

        if($values->order){
            $order_arr = array();
            foreach($values->order as $item){
                if($item->by && $item->dir){
                    $order_arr[$item->by] = $item->dir;
                }
            }

            if(count($order_arr) > 0){
                $this->filter->setOrderBy($order_arr);
            }
        }

        $this->redrawControl();
    }

    protected function createComponentFilterForm(){

        $form = new \Nette\Application\UI\Form;

        $form->addGroup('Filtrování');

        $form->addText('id','Id');
        $form->addText('subquestions','Počet otázek');
        $form->addText('correct','Počet správně');
        $form->addText('percentages','Úspěšnost');

        $this->addOrder($form, array(
            'total_subquestions'=>'počet otázek',
            'total_correct_subquestions'=>'počet správně',
            'total_correct_subquestions_percents'=>'úspěšnost'
        ));

        $form->onSuccess[] = $this->filterFormSubmited;

        $form->addGroup();

        $form->addSubmit('filter','Filtrovat')->setAttribute("class","btn btn-primary ajax");

        return $form;
    }


}