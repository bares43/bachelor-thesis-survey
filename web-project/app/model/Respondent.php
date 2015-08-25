<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 16:25
 */
namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class Respondent extends BaseEntity {

    const DEVICE_COMPUTER = "c";
    const DEVICE_TABLET = "t";
    const DEVICE_PHONE = "p";

    const GENDER_MALE = "m";
    const GENDER_FEMALE = "f";

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * @var int $id_repondent
     */
    public $id_respondent;

    /**
     * @ORM\Column(type="integer")
     */
    public $age;

    /**
     * @ORM\Column(type="string")
     */
    public $gender;

    /**
     * @ORM\Column(type="boolean")
     */
    public $device_computer;

    /**
     * @ORM\Column(type="boolean")
     */
    public $device_tablet;

    /**
     * @ORM\Column(type="boolean")
     */
    public $device_phone;

    /**
     * @ORM\Column(type="string")
     */
    public $device_most;



}