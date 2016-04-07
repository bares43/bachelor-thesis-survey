<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 11. 11. 2015
 * Time: 21:20
 */

namespace App\Model;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\BaseEntity;

/**
 * @ORM\Entity
 */
class RespondentPageDuel extends BaseEntity {

    const MORE_OFTEN_PAGE = "P";
    const MORE_OFTEN_BOTH = "B";
    const MORE_OFTEN_NONE = "N";

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public $id_respondent_page_duel;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_respondent;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_page_related;

    /**
     * @ORM\Column(type="string")
     */
    public $more_often;

    /**
     * @ORM\Column(type="integer")
     */
    public $id_page;

    /**
     * @ORM\Column(type="datetime")
     */
    public $datetime;

}