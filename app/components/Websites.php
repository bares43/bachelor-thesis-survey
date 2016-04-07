<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 19. 12. 2015
 * Time: 17:01
 */

namespace App\Components;


use App\Service\Website;
use App\Utils\Filter;
use Nette\Application\UI\Form;

class Websites extends FilterComponent{


    /**
     * @var Website
     */
    private $website_service;

    /**
     * @var \App\Filter\Results\Respondents
     */
    private $filter;

    /**
     * Subquestions constructor.
     * @param Website $website_service
     */
    public function __construct(Website $website_service) {
        parent::__construct();

        $this->filter = new \App\Filter\Results\Websites();

        $this->website_service = $website_service;
    }

    public function render() {
        $websites = $this->website_service->getResultsWebsites($this->filter);

        $template = $this->prepareTemplate();

        $template->websites = $websites;
        $template->count = count($websites);

        $template->render();
    }


    /**
     * @param Form $form
     */
    public function filterFormSubmited(Form $form) {
        $values = $form->getValues();

        if($values->id){
            $this->filter->setIdsWebsites(Filter::createFilterArray($values->id));
        }

        if($values->subquestions){
            $this->filter->setSubquestions(Filter::createFilterArray($values->subquestions));
        }

        if($values->correct){
            $this->filter->setCorrect(Filter::createFilterArray($values->correct));
        }

        if($values->almost){
            $this->filter->setAlmost(Filter::createFilterArray($values->almost));
        }

        if($values->wrong){
            $this->filter->setWrong(Filter::createFilterArray($values->wrong));
        }

        if($values->disqualified){
            $this->filter->setDisqualified(Filter::createFilterArray($values->disqualified));
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
        $form->addText('almost','Počet téměř');
        $form->addText('wrong','Počet špatně');
        $form->addText('disqualified','Počet nepočítaných');
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