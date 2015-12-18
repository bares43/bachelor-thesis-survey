<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 18. 12. 2015
 * Time: 16:51
 */

namespace App\Components;


use App\Base\Component;
use App\Service\Question;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Forms\Controls\SubmitButton;

class Subquestions extends Component{

    /**
     * @var Question;
     */
    private $question_service;

    /**
     * @var \App\Filter\Results\Subquestions
     */
    private $filter;

    /**
     * Subquestions constructor.
     * @param Question $question_service
     */
    public function __construct(Question $question_service) {
        parent::__construct();

        $this->filter = new \App\Filter\Results\Subquestions();

        $this->question_service = $question_service;
    }

    public function render() {

        $template = $this->createTemplate();

        $template->setFile(__DIR__."/subquestions.latte");

        $template->subquestions = $this->question_service->getResultsSubquestion($this->filter);

        $template->render();
    }


    /**
     * @param Form $form
     */
    public function filterFormSubmited(Form $form) {
        $value = $form->getValues();


//        var_dump($form->httpData);
//
//        var_dump($value);exit;

        $this->filter->setIdRespondent($value->id_respondent);

        $this->redrawControl();
    }

    protected function createComponentFilterForm(){

        $form = new Form();

        $form->addGroup('Filtrování');

        $form->addText('id_respondent','Respondent');

        $seconds = $form->addContainer('time');
        $seconds->addText(0,'Čas')->setAttribute('class','duplicable');

        $form->addGroup('Řazení');
        $order = $form->addContainer('order')->addContainer(0);
        $order->addSelect('by','Položka',array('čas','typ'));
        $order->addSelect('dir','Směr',array('asc','desc'));

        $form->onSuccess[] = $this->filterFormSubmited;

        $form->addSubmit('filter','Filtrovat')->setAttribute('class','ajax');

        return $form;
    }
}