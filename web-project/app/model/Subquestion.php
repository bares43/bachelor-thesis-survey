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
class Subquestion extends BaseEntity {

    const QUESTION_TYPE_WIREFRAME = 1;
    const QUESTION_TYPE_WIREFRAME_SELECT = 2;
    const QUESTION_TYPE_WIREFRAME_REVERSE = 3;
    const QUESTION_TYPE_COLOR = 4;
    const QUESTION_TYPE_COLOR_SELECT = 5;

    const CORRECT = 1;
    const WRONG = 0;
    const ALMOST = 2;

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
     * @ORM\Column(type="integer")
     */
    public $correct;

    /**
     * @ORM\Column(type="string")
     */
    public $reason;

    /**
     * @ORM\Column(type="integer")
     */
    public $seconds;

    /**
     * @ORM\Column(type="datetime")
     */
    public $datetime;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_page_related;

    /**
     * @ORM\Column(type="boolean")
     */
    public $visible;
}