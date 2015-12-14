<?php

/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 14. 12. 2015
 * Time: 1:57
 */

namespace App\Auth;

use App\Service\User;
use Nette\Security\AuthenticationException;
use Nette\Security\Identity;
use Nette\Security\Passwords;

class Authenticator extends \Nette\Object implements \Nette\Security\IAuthenticator{

    /** @var  Users */
    public $user_service;

    /**
     * Authenticator constructor.
     * @param User $user_service
     */
    function __construct(User $user_service)
    {
        $this->user_service = $user_service;
    }

    function authenticate(array $credentials) {
        list($username, $password) = $credentials;

        $user = $this->user_service->getByLogin($username);

        if (!$user) {
            throw new AuthenticationException('Přihlášení se nezdařilo.');
        }

        if (!Passwords::verify($password, $user->password)) {
            throw new AuthenticationException('Přihlášení se nezdařilo.');
        }

        return new Identity($user->id_user);
    }
}