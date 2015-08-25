<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:06
 */
namespace App\Service;

use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Questions extends BaseService {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Question::class);
    }

    /**
     * @return Model\Question[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Question|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Question $question
     */
    public function save(Model\Question $question)
    {
        $this->_save($question);
    }
}