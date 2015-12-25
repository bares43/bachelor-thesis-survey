<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 18. 12. 2015
 * Time: 16:51
 */

namespace App\Components;


use App\Base\Component;
use App\Model\RespondentWebsite;
use App\Service\Page;
use App\Service\Question;
use App\Service\Website;
use App\Utils\Filter;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Forms\Controls\SubmitButton;

class Subquestions extends FilterComponent{

    /**
     * @var Question;
     */
    private $question_service;

    /**
     * @var Website
     */
    private $website_service;

    /** @var Page */
    private $page_service;

    /**
     * @var \App\Filter\Results\Subquestions
     */
    private $filter;

    /**
     * @var int
     */
    private $id_respondent = null;

    /**
     * Subquestions constructor.
     * @param Question $question_service
     * @param Website $website_service
     * @param Page $page_service
     */
    public function __construct(Question $question_service, Website $website_service, Page $page_service) {
        parent::__construct();

        $this->filter = new \App\Filter\Results\Subquestions();

        $this->website_service = $website_service;
        $this->question_service = $question_service;
        $this->page_service = $page_service;
    }

    /**
     * @param int|null $id_respondent
     */
    public function render($id_respondent = null) {
        if($id_respondent !== null){
            $this->filter->setIdRespondents(array($id_respondent));
            $this->id_respondent = $id_respondent;
        }

        $subquestions = $this->question_service->getResultsSubquestion($this->filter);

        $template = $this->prepareTemplate();

        $template->subquestions = $subquestions;
        $template->count = count($subquestions);

        $template->render();
    }


    /**
     * @param Form $form
     */
    public function filterFormSubmited(Form $form) {
        $values = $form->getValues();


        if($values->id_respondent){
            $this->filter->setIdRespondents(Filter::createFilterArray($values->id_respondent));
        }

        if($values->seconds){
            $this->filter->setSeconds(Filter::createFilterArray($values->seconds));
        }

        if($values->id){
            $this->filter->setIds(Filter::createFilterArray($values->id));
        }

        if($values->id_question){
            $this->filter->setIdsQuestions(Filter::createFilterArray($values->id_question));
        }

        if($values->datetime){
            $this->filter->setDatetimes(Filter::createFilterArray($values->datetime));
        }

        if($values->id_page){
            $this->filter->setPages(Filter::createFilterArray($values->id_page));
        }

        if($values->id_website){
            $this->filter->setWebsites(Filter::createFilterArray($values->id_website));
        }

        if($values->type){
            $this->filter->setTypes(Filter::createFilterArray($values->type));
        }

        if($values->correct !== null){
            $this->filter->setCorrects(Filter::createFilterArray($values->correct));
        }

        if($values->answer){
            $this->filter->setAnswer($values->answer);
        }

        if($values->reason){
            $this->filter->setReason($values->reason);
        }

        if($values->know){
            $this->filter->setKnowns(Filter::createFilterArray($values->know));
        }

        if($values->visible === "1"){
            $this->filter->setVisibility(true);
        }elseif($values->visible === "0"){
            $this->filter->setVisibility(false);
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
        $websites_arr = array();
        foreach($this->website_service->getAll() as $website){
            $websites_arr[$website->id_website] = $website->name;
        }

        $pages_arr = array();
        foreach($this->page_service->getBasePageHolders() as $pageHolder){
            $pages_arr[$pageHolder->getPage()->id_page] = $pageHolder->getWebsite()->name." - ".$pageHolder->getPage()->name;
        }

        $form = new \Nette\Application\UI\Form;

        $form->addGroup('Filtrování');

        $form->addText('id','Id');
        $form->addText('id_question','Rodič');
        $input_respondent = $form->addText('id_respondent','Respondent');
        if($this->id_respondent !== null){
            $input_respondent->setDefaultValue($this->id_respondent);
        }
        $form->addText('datetime','Čas');
        $form->addText('correct','Správně');
        $form->addText('answer','Odpověď');
        $form->addText('reason','Důvod');
        $form->addText('type','Typ');
        $form->addText('seconds','Sekundy');
        $form->addText('visible','Viditelnost');
        $form->addCheckboxList('know','Zná?',array(
           "null"=>"nevyplněno",
           RespondentWebsite::PERIOD_DONT_KNOW=>'neznám',
           RespondentWebsite::PERIOD_KNOW_THAT_EXISTS=>'vím, že existuje',
           RespondentWebsite::PERIOD_KNOW_AND_VISIT=>'znám a navštěvuji'
        ));

        $websites = $form->addDynamic("id_website", function(Container $website) use ($websites_arr) {
            $website->addSelect("id_website","Web",$websites_arr);
            $website->addSubmit('removeWebsite', 'Odstranit')
                ->setAttribute("class","ajax btn btn-xs")
                ->setValidationScope(FALSE)
                ->onClick[] = array($this, 'removeItem');
        });
        $websites->addSubmit('addWebsite', 'Přidat web')
            ->setValidationScope(FALSE)
            ->setAttribute("class","ajax btn btn-xs")
            ->onClick[] = array($this, 'addItem');

        $pages = $form->addDynamic("id_page", function(Container $website) use($pages_arr){
            $website->addSelect("id_page","Stránka",$pages_arr);
            $website->addSubmit('removePage', 'Odstranit')
                ->setAttribute("class","ajax btn btn-xs")
                ->setValidationScope(FALSE)
                ->onClick[] = array($this, 'removeItem');
        });
        $pages->addSubmit('addPage', 'Přidat stránku')
            ->setValidationScope(FALSE)
            ->setAttribute("class","ajax btn btn-xs")
            ->onClick[] = array($this, 'addItem');

        $this->addOrder($form, array(
            'subquestion.id_subquestion'=>"id",
            'question.id_question'=>"rodič",
            'subquestion.seconds'=>'sekundy',
            'question.id_respondent'=>'respondent',
            'subquestion.datetime'=>'čas'
        ));

        $form->onSuccess[] = $this->filterFormSubmited;

        $form->addGroup();

        $form->addSubmit('filter','Filtrovat')->setAttribute("class","btn btn-primary ajax");

        return $form;
    }

}