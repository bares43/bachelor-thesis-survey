<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 18:50
 */

namespace App\Forms;


use App\Model\RespondentPageDuel;
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
     * @param \App\Holder\PageRelated[] $duels
     * @return Form
     */
    public function create($websites, $duels){
        $periods = array(RespondentWebsite::PERIOD_KNOW_AND_VISIT=>"Znám a navštěvuji",RespondentWebsite::PERIOD_KNOW_THAT_EXISTS=>"Pouze vím, že existuje",RespondentWebsite::PERIOD_DONT_KNOW=>"Neznám");

        $form = new Form($this->parent, "finalForm");

        $form->addGroup("Jak často navštěvujete následující stránky?");
        $websites_container = $form->addContainer("website");


        foreach($websites as $website_id=>$website_name){
            $website_container = $websites_container->addContainer($website_id);
            $website_container->addRadioList("period",$website_name,$periods)->setAttribute("class","buttons-group");
        }


        $form->addGroup("Jaké stránky navštěvujete častěji?");
        $duels_container = $form->addContainer("duels");

        foreach($duels as $page_related_holder){
            $duel_container = $duels_container->addContainer($page_related_holder->getPageRelated()->id_page_related);
            $title = $page_related_holder->getPageA()->getWebsite()->name ." vs. ".$page_related_holder->getPageA()->getWebsite()->name;
            $options = array(
                $page_related_holder->getPageA()->getPage()->id_page=>$page_related_holder->getPageA()->getWebsite()->name,
                RespondentPageDuel::MORE_OFTEN_BOTH=>"nastejno",
                $page_related_holder->getPageB()->getPage()->id_page=>$page_related_holder->getPageB()->getWebsite()->name,
                RespondentPageDuel::MORE_OFTEN_NONE=>"nenavštěvuji ani jeden web"
            );
            $duel_container->addRadioList("page",$title,$options)->setAttribute("class","buttons-group");
        }

        $form->addGroup(null);

        $form->addText("email","E-mail")->setType("email");
        $form->addSubmit("send","Dokončit dotazník")->setAttribute("class","btn btn-lg btn-primary");

        return $form;
    }
}