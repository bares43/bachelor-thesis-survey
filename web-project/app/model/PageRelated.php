<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 28. 9. 2015
 * Time: 14:26
 */

namespace App\Model;


use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class PageRelated extends BaseEntity {

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_page_related;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_page_a;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_page_b;

    /**
     * @ORM\Column(type="boolean")
     */
    public $duel;
}