<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 14. 12. 2015
 * Time: 1:48
 */

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;


class SignForm extends Nette\Object
{
    /** @var User */
    private $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * @return Form
     */
    public function create()
    {


        $form = new Form;

        $form->addText('username', 'Login:')
            ->setRequired('Zadejte login.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Zadejte heslo.');

        $form->addCheckbox('remember', 'Zapamatovat');

        $form->addSubmit('send', 'Přihlásit')->setAttribute("class","btn btn-primary");

        $form->onSuccess[] = array($this, 'formSucceeded');



        $form->getElementPrototype()->addAttributes(['class'=>'center']);
        return $form;
    }


    public function formSucceeded(Form $form, $values)
    {
        if ($values->remember) {
            $this->user->setExpiration('14 days', FALSE);
        } else {
            $this->user->setExpiration('20 minutes', TRUE);
        }

        try {
            $this->user->login($values->username, $values->password);
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

}