<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 21:19
 */

namespace App\Presenters;

use Nette;
use App\Model\Respondent;
use Nette\Application\UI\Form;

class PersonalPresenter extends Nette\Application\UI\Presenter {

    /**
     * @return Form
     */
    public function createComponentPersonalForm() {
        $validaton_message = "Vyplňte prosím %s. Pomůže mi to lépe zpracovat výsledky průzkumu. Díky ;)";

        $form = new Form();

        $form->addGroup("Obecné");
        $sex = array(
            Respondent::GENDER_MALE => 'muž',
            Respondent::GENDER_FEMALE => 'žena',
        );
        $form->addRadioList('gender', 'Pohlaví:', $sex)
            ->addRule(Form::REQUIRED,$validaton_message,"svoje pohlaví");

        $form->addText("age", "Věk:")
            ->setType("number")
            ->addRule(Form::INTEGER,$validaton_message,"svůj věk");

        $form->addCheckbox("english", "Navštěvuji i anglické webové stránky");

        $devices = array(Respondent::DEVICE_COMPUTER=>"Počítač nebo notebook", Respondent::DEVICE_PHONE=>"Smartphone", Respondent::DEVICE_TABLET=>"Tablet");
        $form->addCheckboxList('devices', 'K přístupu na internet používám:', $devices)
            ->addRule(Form::REQUIRED,$validaton_message,"které zařízení používáte pro přístup k internetu");

        $form->addRadioList("devices_most", "A z toho nejčastěji", $devices)
          ->addRule(Form::REQUIRED,$validaton_message,"které zařízení nejčastěji používáte pro přístup k internetu");

        $period = array(
            "vůbec",
            "denně",
            "několikrát týdně",
            "několikrát měsíčně",
            "několikrát ročně"
        );

        $form->addGroup("Komunikace (Sociální sítě, e-mail)");
        $form->addRadioList("comunication_period", "Jak často?", $period);

        $form->addGroup("Nakupování");
        $form->addRadioList("shopping_period", "Jak často?", $period);

        $shopping = array("Elektronika", "Oblečení", "Elektronický obsah (e-knihy, hudba)", "Potraviny", "Bazar");
        $form->addCheckboxList("shopping_subject", "Co?", $shopping);

        $form->addGroup("Zprávy");
        $form->addRadioList("news_period", "Jak často?", $period);

        $form->addGroup("Zajímá mě to");
        $form->addText("email","E-mail")->setType("email");
        $form->addTextArea("note","Vzkaz");
        $form->addTextArea("pages","Jaké stránky často navštěvuji");

        $form->addSubmit("validate","Odeslat")->setAttribute("class","btn btn-default");
        $form->addSubmit("nonvalidate","Nechci o sobě sdělovat údaje")->setValidationScope(FALSE)->setAttribute("class","btn btn-default");






        // setup form rendering
        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = NULL;
        $renderer->wrappers['pair']['container'] = 'div class=form-group';
        $renderer->wrappers['pair']['.error'] = 'has-error';
        $renderer->wrappers['control']['container'] = 'div class=col-sm-9';
        $renderer->wrappers['label']['container'] = 'div class="col-sm-3 control-label"';
        $renderer->wrappers['control']['description'] = 'span class=help-block';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';
        // make form and controls compatible with Twitter Bootstrap
        $form->getElementPrototype()->class('form-horizontal');
        foreach ($form->getControls() as $control) {
            if ($control instanceof Controls\Button) {
                $control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
                $usedPrimary = TRUE;
            } elseif ($control instanceof Controls\TextBase || $control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox) {
                $control->getControlPrototype()->addClass('form-control');
            } elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
                $control->getSeparatorPrototype()->setName('div')->addClass($control->getControlPrototype()->type);
            }
        }




        return $form;
    }
}