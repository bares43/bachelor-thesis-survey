<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 18. 12. 2015
 * Time: 16:15
 */

namespace App\Holder\Mapper\Results\Respondent;


use App\Base\IHolder;
use App\Base\IMapper;
use App\Base\Service;
use App\Model\EntityCategory;

class Category implements IMapper{

    /**
     * @param $result
     * @return IHolder
     */
    public function populate($result) {
        $holder = new \App\Holder\Results\Respondent\Category();

        if(isset($result["category_id_category"])){
            $holder->setCategory(Service::populateEntity($result, \App\Model\Category::getClassName(), "category"));
        }

        if(isset($result["entitycategory_id_entity_category"])){
            $holder->setEntitycategory(Service::populateEntity($result, EntityCategory::getClassName(), "entitycategory"));
        }

        return $holder;
    }
}