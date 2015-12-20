<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 19. 12. 2015
 * Time: 16:16
 */

namespace App\Components;


use App\Service\Respondent;
use App\Utils\Filter;
use Nette\Application\UI\Form;
use Nette\Forms\Container;

class Respondents extends FilterComponent {


    /**
     * @var Respondent
     */
    private $respondent_service;

    /**
     * @var \App\Filter\Results\Respondents
     */
    private $filter;

    /**
     * Subquestions constructor.
     * @param Respondent $respondent_service
     */
    public function __construct(Respondent $respondent_service) {
        parent::__construct();

        $this->filter = new \App\Filter\Results\Respondents();

        $this->respondent_service = $respondent_service;
    }

    public function render() {

        $template = $this->prepareTemplate();

        $template->respondents = $this->respondent_service->getResultsRespondent($this->filter);

        $template->render();
    }


    /**
     * @param Form $form
     */
    public function filterFormSubmited(Form $form) {
        $values = $form->getValues();


        if ($values->id) {
            $this->filter->setRespondents(Filter::createFilterArray($values->id));
        }

        if ($values->percentages) {
            $this->filter->setPercentages(Filter::createFilterArray($values->percentages));
        }

        if ($values->questions) {
            $this->filter->setQuestions(Filter::createFilterArray($values->questions));
        }

        if ($values->subquestions) {
            $this->filter->setSubquestions(Filter::createFilterArray($values->subquestions));
        }

        if ($values->correct) {
            $this->filter->setCorrects(Filter::createFilterArray($values->correct));
        }

        if ($values->wrong) {
            $this->filter->setWrongs(Filter::createFilterArray($values->wrong));
        }

        if ($values->unknown) {
            $this->filter->setUnknowns(Filter::createFilterArray($values->unknown));
        }

        if ($values->websites) {
            $this->filter->setWebsites($values->websites);
        }

        if ($values->datetime) {
            $this->filter->setDatetimes(Filter::createFilterArray($values->datetime));
        }

        if($values->age){
            $this->filter->setAges(Filter::createFilterArray($values->age));
        }

        if($values->gender){
            $this->filter->setGenders(Filter::createFilterArray($values->gender));
        }

        if($values->english){
            $this->filter->setEnglishes(Filter::createFilterArray($values->english));
        }

        if($values->it){
            $this->filter->setIts(Filter::createFilterArray($values->it));
        }

        if ($values->order) {
            $order_arr = array();
            foreach ($values->order as $item) {
                if ($item->by && $item->dir) {
                    $order_arr[$item->by] = $item->dir;
                }
            }

            if (count($order_arr) > 0) {
                $this->filter->setOrderBy($order_arr);
            }
        }

        $this->redrawControl();
    }

    protected function createComponentFilterForm() {

        $form = new \Nette\Application\UI\Form;

        $form->addGroup('Filtrování');

        $form->addText('id', 'Id');
        $form->addText('datetime', 'Čas');
        $form->addCheckboxList('age', 'Věk', array(
            null => "neznámé",
            \App\Model\Respondent::AGE_15 => "<15",
            \App\Model\Respondent::AGE_15_20 => "15-20",
            \App\Model\Respondent::AGE_21_30 => "21-30",
            \App\Model\Respondent::AGE_31_45 => "31-45",
            \App\Model\Respondent::AGE_46_60 => "46-60",
            \App\Model\Respondent::AGE_60 => ">60",
        ));
        $form->addCheckboxList('gender', 'Pohlaví', array(
            null => "neznámé",
            \App\Model\Respondent::GENDER_MALE => "muž",
            \App\Model\Respondent::GENDER_FEMALE => "žena"
        ));
        $form->addCheckboxList('english', 'Angličtina', array(
            null => "neznámé",
            1 => "ano",
            0 => "ne"
        ));
        $form->addCheckboxList('it', 'It', array(
            null => "neznámé",
            1 => "ano",
            0 => "ne"
        ));
        $form->addText('devices', 'Zařízení');
        $form->addText('device_most', 'Nejčastější zařízení');
        $form->addText('websites', 'Navštěvované stránky');
        $form->addText('questions', 'Otázek');
        $form->addText('subquestions', 'Podotázek');
        $form->addText('correct', 'Správně');
        $form->addText('wrong', 'Špatně');
        $form->addText('unknown', 'Nevyhodnoceno');
        $form->addText('percentages', 'Procenta');

        $this->addOrder($form, array(
            'respondent.id_respondent' => 'id',
            'respondent.datetime' => 'čas',
            'total_questions' => 'počet otázek',
            'total_subquestions' => 'počet podotázek',
            'total_correct_subquestions' => 'správně',
            'total_wrong_subquestions' => 'špatně',
            'total_unknown_subquestions' => 'nevyhodnoceno',
            'total_correct_subquestions_percents' => 'úspěšnost'
        ));

        $form->onSuccess[] = $this->filterFormSubmited;

        $form->addGroup();

        $form->addSubmit('filter', 'Filtrovat')->setAttribute("class", "btn btn-primary ajax");

        return $form;
    }

}