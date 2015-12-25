<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 14. 12. 2015
 * Time: 1:20
 */

namespace App\Holder\Mapper\Results\Base;


use App\Base\IHolder;
use App\Base\IMapper;
use App\Base\Service;

class Page implements IMapper{

    /**
     * @param $result
     * @return IHolder
     */
    public function populate($result) {
        $holder = new \App\Holder\Results\Base\Page();

        if(isset($result["page_id_page"])){
            $holder->setPage(Service::populateEntity($result, \App\Model\Page::getClassName(), "page"));
        }

        if(isset($result["website_id_website"])){
            $holder->setWebsite(Service::populateEntity($result, \App\Model\Website::getClassName(), "website"));
        }

        if(isset($result["total_subquestions"])){
            $holder->setTotalSubquestions((int)$result["total_subquestions"]);
        }

        if(isset($result["total_correct_subquestions"])){
            $holder->setTotalCorrectSubquestions((int)$result["total_correct_subquestions"]);
        }

        if(isset($result["total_correct_subquestions_percents"])){
            $holder->setTotalCorrectSubquestionsPercents((float)$result["total_correct_subquestions_percents"]);
        }

        return $holder;
    }
}