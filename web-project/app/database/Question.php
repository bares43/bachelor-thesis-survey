<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:06
 */
namespace App\Database;

use App\Base\Database;
use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Question extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Question::getClassName());
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

    /**
     * @param int $id_respondent
     * @return Model\Question[]
     */
    public function getByIdRespondent($id_respondent) {
        return $this->entityManager->getRepository($this->repositoryName)->findBy(array("id_respondent"=>$id_respondent));
    }

    /**
     * @param $id_respondent
     * @param $id_page
     * @return Model\Question
     */
    public function create($id_respondent, $id_page)
    {
        $question = new Model\Question();
        $question->id_respondent = $id_respondent;
        $question->id_page = $id_page;
        $this->save($question);
        return $question;
    }
}