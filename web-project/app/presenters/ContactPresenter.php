<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 26. 8. 2015
 * Time: 9:51
 */
namespace App\Presenters;

use Latte\Engine;
use Nette;
use App\Model;
use \App\Forms\ContactForm;
use Nette\Mail\Message;

class ContactPresenter extends Nette\Application\UI\Presenter {

    /**
     * @param Nette\Application\UI\Form $form
     */
    public function contactFormSubmitted(Nette\Application\UI\Form $form){
        $values = $form->getValues();

        if($this->context->getParameters()["send_emails"]){

            $latte = new Engine();

            $mail = new Message;
            $mail->setFrom($this->context->getParameters()["mailer_mail"])
                ->addTo($this->context->getParameters()["mailer_mail"])
                ->setHtmlBody($latte->renderToString(__DIR__ . '/templates/Contact/email.latte', array(
                    "email"=>$values->email,
                    "content"=>$values->content
                )));

            $mailer = new Nette\Mail\SmtpMailer(array(
                'host' => $this->context->getParameters()["mailer_host"],
                'username' => $this->context->getParameters()["mailer_mail"],
                'password' => $this->context->getParameters()["mailer_password"],
                'secure' => 'ssl',
            ));
            $mailer->send($mail);

        }

        $this->redirect("Contact:sent");
    }

    /**
     * @return ContactForm
     */
    public function createComponentContactForm() {
        $form = (new ContactForm($this))->create();

        $form->onSuccess[] = $this->contactFormSubmitted;

        return $form;
    }

}