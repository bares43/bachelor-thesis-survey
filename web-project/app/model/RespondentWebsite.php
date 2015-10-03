<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 14. 9. 2015
 * Time: 20:43
 */

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class RespondentWebsite extends BaseEntity {

    const PERIOD_KNOW_AND_VISIT = 1;
    const PERIOD_KNOW_THAT_EXISTS = 2;
    const PERIOD_DONT_KNOW = 3;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_respondent_website;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_respondent;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_website;

    /**
     * @ORM\Column(type="integer")
     */
    public $period;

    /**
     * @ORM\Column(type="datetime")
     */
    public $datetime;

}