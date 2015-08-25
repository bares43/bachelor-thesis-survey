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