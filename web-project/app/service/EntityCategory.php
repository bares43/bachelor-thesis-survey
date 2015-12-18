<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 3. 10. 2015
 * Time: 10:37
 */

namespace App\Service;

use App\Base\Service;
use App\Filter\Results\RespondentCategory;

class EntityCategory extends Service {

    /** @var \App\Database\EntityCategory */
    private $database;

    /**
     * EntityCategory constructor.
     * @param \App\Database\EntityCategory $database
     */
    public function __construct(\App\Database\EntityCategory $database) {
        $this->database = $database;
    }

    /**
     * @param int $id_category
     * @param int $id_respondent
     * @param int $period
     */
    public function addCategoryToRespondent($id_category, $id_respondent, $period) {
        $entity_category = new \App\Model\EntityCategory();
        $entity_category->id_category = $id_category;
        $entity_category->id_respondent = $id_respondent;
        $entity_category->period = $period;
        $this->save($entity_category);
    }

    /**
     * @param int $id_respondent
     * @return \App\Model\EntityCategory[]
     */
    public function getEntityCategoriesByIdRespondent($id_respondent) {
        return $this->database->getEntityCategoriesByIdRespondent($id_respondent);
    }

    /**
     * @param \App\Model\EntityCategory $entity
     */
    public function save($entity) {
        $this->database->save($entity);
    }

    /**
     * @param RespondentCategory $filter
     * @return \App\Holder\Results\Respondent\Category[]
     */
    public function getResultsRespondentCategory($filter) {
        return $this->database->getResultsRespondentCategory($filter);
    }
}