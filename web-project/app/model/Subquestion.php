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
class Subqestion extends BaseEntity {

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_subquestion;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_question;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_wireframe;

    /**
     * @ORM\Column(type="integer")
     */
    public $question_type;

    /**
     * @ORM\Column(type="string")
     */
    public $answer;

    /**
     * @ORM\Column(type="boolean")
     */
    public $correct;
}