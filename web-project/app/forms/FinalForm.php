<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 18:50
 */

namespace App\Forms;


use App\Model\RespondentWebsite;
use App\Model\Website;
use Nette\Application\UI\Form;

class FinalForm {

    private $parent;

    /**
     * FinalForm constructor.
     * @param $parent
     */
    public function __construct($parent) {
        $this->parent = $parent;
    }

    /**
     * @param string[] $websites
     * @return Form
     */
    public function create($websites){
        $periods = array(RespondentWebsite::PERIOD_KNOW_AND_VISIT=>"Znám a navštěvuji",RespondentWebsite::PERIOD_KNOW_THAT_EXISTS=>"Pouze vím, že existuje",RespondentWebsite::PERIOD_DONT_KNOW=>"Neznám");

        $form = new Form($this->parent, "finalForm");

        $websites_container = $form->addContainer("website");

        foreach($websites as $website_id=>$website_name){
            $website_container = $websites_container->addContainer($website_id);
            $website_container->addRadioList("period",$website_name,$periods)->setAttribute("class","buttons-group");
        }

        $form->addText("email","E-mail")->setType("email");
        $form->addSubmit("send","Dokončit dotazník")->setAttribute("class","btn btn-lg btn-primary");

        return $form;
    }
}