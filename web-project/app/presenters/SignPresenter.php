<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 14. 12. 2015
 * Time: 2:23
 */

namespace App\Presenters;


use App\Auth\Authenticator;
use App\Base\Presenter;
use App\Forms\SignForm;
use App\Service\User;

class SignPresenter extends Presenter{

    /** @var  User @inject */
    public $user_service;

    public function actionLogout() {
        $this->getUser()->logout();
        $this->redirect('Homepage:');
    }

    /**
     * @return Form
     */
    public function createComponentSignForm() {

        $authenticator = new Authenticator($this->user_service);

        $this->getUser()->setAuthenticator($authenticator);

        $form = (new SignForm($this->getUser()))->create();

        $form->onSuccess[] = function ($form) {
            $form->getPresenter()->redirect("Results:");
        };

        return $form;
    }
}