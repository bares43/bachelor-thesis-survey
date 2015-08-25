<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 16:24
 */

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class Page extends BaseEntity {

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_page;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_website;

    /**
     * @ORM\Column(type="string")
     */
    public $name;

    /**
     * @ORM\Column(type="string")
     */
    public $url;

    /**
     * @ORM\Column(type="string")
     */
    public $dominant_color;

    /**
     * @ORM\Column(type="string")
     */
    public $dominant_text_color;
}