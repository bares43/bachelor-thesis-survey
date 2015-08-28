<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 8. 2015
 * Time: 18:50
 */

namespace App\Forms;


use App\Model\Website;
use Nette\Application\UI\Form;

class FinalForm {

    /**
     * @param Website[] $websites
     * @return Form
     */
    public function create($websites){
        $periods = array("Znám a navštěvuji","Pouze vím, že existuje","Neznám");

        $form = new Form();

        foreach($websites as $website){
            $form->addRadioList("webpage_".$website->id_website,$website->name,$periods)->setAttribute("class","buttons-group");
        }

        $form->addText("email","E-mail")->setType("email");
        $form->addSubmit("send","Dokončit dotazník")->setAttribute("class","btn btn-lg btn-primary");

        return $form;
    }
}