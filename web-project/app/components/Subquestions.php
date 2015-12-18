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
        $values = $form->getValues();


        $filter_seconds = array();
        if($values->seconds){
            $items = explode(",",$values->seconds);

            foreach($items as $seconds){

                if(preg_match('/([<>]?=?)(.+)/',$seconds, $match)){
                    if($match[1]){
                        $filter_seconds[$match[1]] = $match[2];
                    }else{
                        $filter_seconds[] = $match[2];
                    }
                }
            }

            $this->filter->setSeconds($filter_seconds);
        }

        $this->filter->setIdRespondent($values->id_respondent);

        $this->redrawControl();
    }

    protected function createComponentFilterForm(){

        $form = new \Nette\Application\UI\Form;

        $form->addGroup('Filtrování');

        $form->addText('id_respondent','Respondent');
        $form->addText('seconds','Čas');

//        $seconds = $form->addDynamic('seconds', function(Container $sec){
//           $sec->addText('seconds','Čas');
//        },0);
//

        $form->addGroup('Řazení');

        $order = $form->addDynamic('order', function(Container $order){
            $order->addSelect('by','Položka',array('čas','typ'));
            $order->addSelect('dir','Směr',array('asc','desc'));
            $order->addSubmit('remove', 'Odstranit')
                ->setAttribute("class","ajax")
                ->setValidationScope(FALSE)
                ->onClick[] = array($this, 'removeOrder');
        });
        $order->addSubmit('addOrder', 'Přidat řazení')
            ->setValidationScope(FALSE)
            ->setAttribute("class","ajax")
            ->onClick[] = array($this, 'addOrder');

        $form->onSuccess[] = $this->filterFormSubmited;

        $form->addSubmit('filter','Filtrovat')->setAttribute('class','ajax');

        return $form;
    }

    public function addOrder(SubmitButton $button)
    {
        $users = $button->parent;

        // count how many containers were filled
        if ($users->isAllFilled()) {
            // add one container to replicator
            $button->parent->createOne();
        }

//        $this->redrawControl();
    }
    public function removeOrder(SubmitButton $button)
    {
        $users = $button->parent->parent;
        $users->remove($button->parent, TRUE);
//        $this->redrawControl();
    }
}