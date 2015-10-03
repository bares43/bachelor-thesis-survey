<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 3. 10. 2015
 * Time: 12:39
 */

namespace App\Database;


use App\Base\Database;
use Kdyby\Doctrine\EntityManager;

class RespondentWebsite extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, \App\Model\RespondentWebsite::getClassName());
    }

    /**
     * @param \App\Model\RespondentWebsite $website
     */
    public function save(\App\Model\RespondentWebsite $website)
    {
        $this->_save($website);
    }
}