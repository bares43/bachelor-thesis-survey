<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 19. 12. 2015
 * Time: 16:14
 */

namespace App\Components;


use App\Base\Component;
use Nette\Forms\Container;
use Nette\Forms\Controls\SubmitButton;

class FilterComponent extends Component{

    /** @var  string */
    private $templateFileName;

    public function addItem(SubmitButton $button) {
        $users = $button->parent;

        // count how many containers were filled
        if ($users->isAllFilled()) {
            // add one container to replicator
            $button->parent->createOne();
        }

//        $this->redrawControl();
    }

    public function removeItem(SubmitButton $button) {
        $users = $button->parent->parent;
        $users->remove($button->parent, TRUE);
//        $this->redrawControl();
    }

    /**
     * @param \Nette\Application\UI\Form $form
     * @param string[] Items
     */
    protected function addOrder($form, $items) {
        $form->addGroup('Řazení');

        $order = $form->addDynamic('order', function (Container $order) use ($items) {
            $order->addSelect('by', 'Položka',$items);
            $order->addRadioList('dir','Směr',array('asc'=>'vzestupně','desc'=>'sestupně'));
            $order->addSubmit('removeOrder', 'Odstranit')
                ->setAttribute("class", "ajax btn btn-xs")
                ->setValidationScope(FALSE)
                ->onClick[] = array($this, 'removeItem');
        });
        $order->addSubmit('addOrder', 'Přidat řazení')
            ->setValidationScope(FALSE)
            ->setAttribute("class", "ajax btn btn-xs")
            ->onClick[] = array($this, 'addItem');
    }

    /**
     * @return \Nette\Application\UI\ITemplate
     */
    public function prepareTemplate() {
        $template = $this->createTemplate();
        $template->setFile($this->getTemplateFileName());
        return $template;
    }

    /**
     * @return string
     */
    public function getTemplateFileName() {
        if($this->templateFileName === null){
            $path = explode('\\', get_called_class());
            $this->templateFileName = __DIR__."/".strtolower(array_pop($path)).".latte";
        }
        return $this->templateFileName;
    }

    /**
     * @param string $templateFileName
     */
    public function setTemplateFileName($templateFileName) {
        $this->templateFileName = $templateFileName;
    }


}