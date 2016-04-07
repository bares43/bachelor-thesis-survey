<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 18. 12. 2015
 * Time: 16:14
 */

namespace App\Holder\Results\Respondent;


use App\Base\IHolder;
use App\Model\EntityCategory;

class Category implements IHolder{

    /**
     * @var \App\Model\Category
     */
    private $category;

    /**
     * @var EntityCategory
     */
    private $entitycategory;

    /**
     * @return \App\Model\Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * @param \App\Model\Category $category
     */
    public function setCategory($category) {
        $this->category = $category;
    }

    /**
     * @return EntityCategory
     */
    public function getEntitycategory() {
        return $this->entitycategory;
    }

    /**
     * @param EntityCategory $entitycategory
     */
    public function setEntitycategory($entitycategory) {
        $this->entitycategory = $entitycategory;
    }


}