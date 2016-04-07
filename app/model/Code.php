<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 3. 10. 2015
 * Time: 15:55
 */

namespace App\Model;


use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class Code extends BaseEntity {

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_code;

    /**
     * @ORM\Column(type="string")
     */
    public $code;

    /**
     * @ORM\Column(type="string")
     */
    public $url;
}