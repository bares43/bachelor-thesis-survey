<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 3. 10. 2015
 * Time: 10:36
 */

namespace App\Database;


use App\Base\Database;
use Kdyby\Doctrine\EntityManager;

class EntityCategory extends Database {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, \App\Model\EntityCategory::getClassName());
    }

    /**
     * @param int $id_respondent
     * @return \App\Model\EntityCategory[]
     */
    public function getEntityCategoriesByIdRespondent($id_respondent) {
        return $this->_getBy(array(
            "id_respondent"=>$id_respondent
        ));
    }

    /**
     * @param \App\Model\EntityCategory $category
     */
    public function save(\App\Model\EntityCategory $category)
    {
        $this->_save($category);
    }

}