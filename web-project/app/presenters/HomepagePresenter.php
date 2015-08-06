<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    public function createComponentSurveyForm()
    {
        $form = new Form();

        $form->addGroup("Obecné");
        $sex = array(
            'm' => 'muž',
            'f' => 'žena',
        );
        $form->addRadioList('gender', 'Pohlaví:', $sex)->getSeparatorPrototype()->setName(NULL);

        $form->addText("age","Věk:")->setType("number")->addRule(Form::INTEGER);

        $form->addCheckbox("english","Navštěvuji i anglické webové stránky");

        $devices = array("Počítač nebo notebook","Smartphone","Tablet");
        $form->addCheckboxList('devices', 'K přístupu na internet používám:', $devices)->getSeparatorPrototype()->setName(NULL);
        $form->addRadioList("devices_most","A z toho nejčastěji",$devices)->getSeparatorPrototype()->setName(NULL);

        $period = array(
            "vůbec",
            "denně",
            "několikrát týdně",
            "několikrát měsíčně",
            "několikrát ročně"
        );

        $form->addGroup("Komunikace (Sociální sítě, e-mail)");
        $form->addRadioList("comunication_period","Jak často?",$period)->getSeparatorPrototype()->setName(NULL);

        $form->addGroup("Nakupování");
        $form->addRadioList("shopping_period","Jak často?",$period)->getSeparatorPrototype()->setName(NULL);
        $shopping = array("Elektronika","Oblečení","Elektronický obsah (e-knihy, hudba)","Potraviny","Bazar");
        $form->addCheckboxList("shopping_subject","Co?",$shopping)->getSeparatorPrototype()->setName(NULL);

        $form->addGroup("Zprávy");
        $form->addRadioList("news_period","Jak často?",$period)->getSeparatorPrototype()->setName(NULL);

        return $form;
    }
}