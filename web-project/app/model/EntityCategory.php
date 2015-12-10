<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 16:27
 */
namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class EntityCategory extends BaseEntity {

    const PERIOD_NEVER = 0;
    const PERIOD_DAILY = 1;
    const PERIOD_FEW_TIMES_A_WEEK = 2;
    const PERIOD_FEW_TIMES_A_MONTH = 3;
    const PERIOD_FEW_TIMES_A_YEAR = 5;
    const MOSTLY = 4;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_entity_category;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_category;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_website;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_respondent;

    /**
     * @ORM\Column(type="integer")
     */
    public $period;
}