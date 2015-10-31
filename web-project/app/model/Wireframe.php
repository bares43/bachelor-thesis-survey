<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 16:26
 */
namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class Wireframe extends BaseEntity {

    const TEXT_LOREM = "lorem";
    const TEXT_ORIGINAL = "original";
    const TEXT_BOX = "box";

    const IMAGE_BOX = "box";
    const IMAGE_ORIGINAL = "original";
    const IMAGE_BLUR = "blur";
    const IMAGE_REMOVE = "remove";

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_wireframe;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_page;

    /**
     * @ORM\Column(type="string")
     */
    public $text_mode;

    /**
     * @ORM\Column(type="string")
     */
    public $image_mode;

    /**
     * @ORM\Column(type="integer")
     */
    public $resolution_width;

    /**
     * @ORM\Column(type="integer")
     */
    public $resolution_height;

    /**
     * @ORM\Column(type="string")
     */
    public $user_agent;

    /**
     * @ORM\Column(type="boolean")
     */
    public $visible;
}