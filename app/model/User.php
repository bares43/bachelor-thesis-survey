<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 14. 12. 2015
 * Time: 2:02
 */

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class User extends BaseEntity{

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_user;

    /**
     * @ORM\Column(type="string")
     */
    public $login;

    /**
     * @ORM\Column(type="string")
     */
    public $password;
}