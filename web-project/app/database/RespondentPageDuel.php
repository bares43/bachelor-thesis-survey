<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 11. 11. 2015
 * Time: 21:26
 */

namespace App\Database;


use App\Base\Database;
use Kdyby\Doctrine\EntityManager;

class RespondentPageDuel extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, \App\Model\RespondentPageDuel::getClassName());
    }

    /**
     * @param \App\Model\RespondentPageDuel $respondent_page_duel
     */
    public function save(\App\Model\RespondentPageDuel $respondent_page_duel)
    {
        if($respondent_page_duel->datetime === null) $respondent_page_duel->datetime = new \DateTime();
        $this->_save($respondent_page_duel);
    }
}