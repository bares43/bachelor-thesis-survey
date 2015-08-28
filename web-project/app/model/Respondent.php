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

    const AGE_15 = '15';
    const AGE_15_20 = '15_20';
    const AGE_21_30 = '21_30';
    const AGE_31_45 = '31_45';
    const AGE_46_60 = '46_60';
    const AGE_60 = '60';

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
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