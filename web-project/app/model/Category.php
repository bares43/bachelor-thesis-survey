<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 16:03
 */

namespace App\Model;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class Category extends BaseEntity {

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_category;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_parent;

    /**
     * @ORM\Column(type="string")
     */
    public $name;

    /**
     * @ORM\Column(type="string")
     */
    public $label;

    /**
     * @ORM\Column(type="integer")
     */
    public $order;

    /**
     * @ORM\Column(type="string")
     */
    public $child_label;
}