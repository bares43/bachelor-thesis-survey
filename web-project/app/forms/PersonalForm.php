<?php

/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 26. 8. 2015
 * Time: 20:55
 */

namespace App\Forms;

use App\Model\Respondent;
use App\Model\EntityCategory;
use Nette\Application\UI\Form;

class PersonalForm {

    /**
     * @return Form
     */
    public function create() {
        $validaton_message = "Vyplňte prosím %s. Pomůže mi to lépe zpracovat výsledky průzkumu. Díky ;)";

        $form = new Form();

        $form->addGroup("Obecné");
        $sex = array(
            Respondent::GENDER_MALE => 'muž',
            Respondent::GENDER_FEMALE => 'žena',
        );
        $form->addRadioList('gender', 'Pohlaví:', $sex)->setAttribute("class","buttons-group")
            ->addRule(Form::REQUIRED,$validaton_message,"svoje pohlaví");

        $age = array(
            Respondent::AGE_15=>'méne něž 15',
            Respondent::AGE_15_20=>'15-20',
            Respondent::AGE_21_30=>'21-30',
            Respondent::AGE_31_45=>'31-45',
            Respondent::AGE_46_60=>'46-60',
            Respondent::AGE_60=>'více než 60'
        );
        $form->addRadioList('age','Věk',$age)->setAttribute('class','buttons-group')
            ->addRule(Form::REQUIRED,$validaton_message,"svůk věk");

        $english = array(1=>"Ano",0=>"Ne");
        $form->addRadioList("english","Navštěvuji Anglické webové stránky",$english)->setAttribute('class','buttons-group')
            ->addRule(Form::REQUIRED,$validaton_message,"zda navštěvujete i anglické webové stránky");

        $form->addTextArea("sites","Jaké stránky často navštěvuji");

        $devices = array(Respondent::DEVICE_COMPUTER=>"Počítač nebo notebook", Respondent::DEVICE_PHONE=>"Smartphone", Respondent::DEVICE_TABLET=>"Tablet");
        $form->addCheckboxList('device', 'K přístupu na internet používám:', $devices)
            ->setAttribute("class","buttons-group")
            ->addRule(Form::REQUIRED,$validaton_message,"které zařízení používáte pro přístup k internetu");

        $form->addRadioList("device_most", "A z toho nejčastěji", $devices)
            ->setAttribute("class","buttons-group")
            ->addRule(Form::REQUIRED,$validaton_message,"které zařízení nejčastěji používáte pro přístup k internetu");

        $period = array(
            EntityCategory::PERIOD_NEVER=>"vůbec",
            EntityCategory::PERIOD_DAILY=>"denně",
            EntityCategory::PERIOD_FEW_TIMES_A_WEEK=>"několikrát týdně",
            EntityCategory::PERIOD_FEW_TIMES_A_MONTH=>"několikrát měsíčně"
        );

        $form->addGroup("Komunikuji na internetu (přes sociální sítě, e-mail)");
        $form->addRadioList("comunication_period", "Jak často?", $period)
            ->setAttribute("class","buttons-group");

        $form->addGroup("Nakupuji na internetu");
        $form->addRadioList("shopping_period", "Jak často?", $period)
            ->setAttribute("class","buttons-group");

        $shopping = array("Elektronika", "Oblečení", "Elektronický obsah (e-knihy, hudba)", "Potraviny", "Bazar");
        $form->addCheckboxList("shopping_subject", "Co nejčastěji?", $shopping)
            ->setAttribute("class","buttons-group");;

        $form->addGroup("Čtu na internetu zprávy");
        $form->addRadioList("news_period", "Jak často?", $period)
            ->setAttribute("class","buttons-group");

        $form->addGroup("Zajímá mě to");
        $form->addText("email","E-mail")->setType("email");
        $form->addTextArea("message","Vzkaz");

        $form->addSubmit("validate","Pokračovat")->setAttribute("class","btn btn-primary");
        $form->addSubmit("nonvalidate","Nechci o sobě sdělovat údaje")->setValidationScope(FALSE)->setAttribute("class","btn btn-default");

        return $form;
    }
}