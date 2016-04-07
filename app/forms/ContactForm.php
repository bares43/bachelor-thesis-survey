<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 5. 11. 2015
 * Time: 1:36
 */

namespace App\Forms;

use Nette\Application\UI\Form;

class ContactForm {

    private $parent;

    /**
     * WireframeForm constructor.
     * @param $parent
     */
    public function __construct($parent) {
        $this->parent = $parent;
    }

    /**
     * @return Form
     */
    public function create() {

        $form = new Form($this->parent,"contactForm");

        $form->addText("email","E-mail")->setType("email")->addRule(Form::REQUIRED,"Vyplňte prosím Váš e-mail.")->addRule(Form::EMAIL, "Vyplňte prosím Váš e-mail.");
        $form->addTextArea("content","Text")->addRule(Form::REQUIRED,"Vyplňte prosím text.");
        $form->addSubmit("send","Odeslat")->setAttribute("class","btn btn-primary");

        return $form;
    }
}