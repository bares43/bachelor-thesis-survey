<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:08
 */
namespace App\Service;

use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Subquestions extends BaseService {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Subquestion::class);
    }

    /**
     * @return Model\Subquestion[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Subquestion|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Subquestion $subquestion
     */
    public function save(Model\Subquestion $subquestion)
    {
        $this->_save($subquestion);
    }

}
