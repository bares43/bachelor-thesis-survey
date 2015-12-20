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
        $template = $this->prepareTemplate();

        $template->pages = $this->page_service->getResultsPages($this->filter);

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
//
//        if($values->seconds){
//            $this->filter->setSeconds(Filter::createFilterArray($values->seconds));
//        }
//
//        if($values->id){
//            $this->filter->setIds(Filter::createFilterArray($values->id));
//        }
//
//        if($values->id_question){
//            $this->filter->setIdsQuestions(Filter::createFilterArray($values->id_question));
//        }
//
//        if($values->datetime){
//            $this->filter->setDatetimes(Filter::createFilterArray($values->datetime));
//        }
//
//        if($values->id_page){
//            $this->filter->setPages(Filter::createFilterArray($values->id_page));
//        }
//
//        if($values->id_website){
//            $this->filter->setWebsites(Filter::createFilterArray($values->id_website));
//        }
//
//        if($values->type){
//            $this->filter->setTypes(Filter::createFilterArray($values->type));
//        }
//
//        if($values->correct){
//            $this->filter->setCorrects(Filter::createFilterArray($values->correct));
//        }
//
//        if($values->answer){
//            $this->filter->setAnswer($values->answer);
//        }
//
//        if($values->reason){
//            $this->filter->setReason($values->reason);
//        }

//        if($values->known){
//            $this->filter->setKnowns(Filter::createFilterArray($values->known));
//        }

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
//        $form->addText('datetime','Čas');
//        $form->addText('age','Věk');
//        $form->addText('gender','Pohlaví');
//        $form->addText('english','Angličtina');
//        $form->addText('it','It');
//        $form->addText('devices','Zařízení');
//        $form->addText('device_most','Nejčastější zařízení');
//        $form->addText('websites','Navštěvované stránky');
//        $form->addText('questions','Otázek');
//        $form->addText('subquestions','Podotázek');
//        $form->addText('correct','Správně');
//        $form->addText('wrong','Špatně');
//        $form->addText('unknown','Nevyhodnoceno');
//        $form->addText('pecentages','Procenta');

        $this->addOrder($form, array(

        ));

        $form->onSuccess[] = $this->filterFormSubmited;

        $form->addGroup();

        $form->addSubmit('filter','Filtrovat')->setAttribute("class","btn btn-primary ajax");

        return $form;
    }


}