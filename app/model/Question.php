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
class Question  extends BaseEntity {

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_question;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_respondent;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_page;

    /**
     * @ORM\Column(type="datetime")
     */
    public $datetime;
}