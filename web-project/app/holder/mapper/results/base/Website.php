<?php
namespace App\Holder\Mapper\Results\Base;


use App\Base\IHolder;
use App\Base\IMapper;
use App\Base\Service;

class Website implements IMapper{

    /**
     * @param $result
     * @return IHolder
     */
    public function populate($result) {
        $holder = new \App\Holder\Results\Base\Website();

        if(isset($result["website_id_website"])){
            $holder->setWebsite(Service::populateEntity($result, \App\Model\Website::getClassName(), "website"));
        }

        if(isset($result["total_subquestions"])){
            $holder->setTotalSubquestions((int)$result["total_subquestions"]);
        }

        if(isset($result["total_correct_subquestions"])){
            $holder->setTotalCorrectSubquestions((int)$result["total_correct_subquestions"]);
        }

        if(isset($result["total_almost_subquestions"])){
            $holder->setTotalAlmostSubquestions((int)$result["total_almost_subquestions"]);
        }

        if(isset($result["total_disqualified_subquestions"])){
            $holder->setTotalDisqualifiedSubquestions((int)$result["total_disqualified_subquestions"]);
        }

        if(isset($result["total_wrong_subquestions"])){
            $holder->setTotalWrongSubquestions((int)$result["total_wrong_subquestions"]);
        }

        if(isset($result["total_correct_subquestions_percents"])){
            $holder->setTotalCorrectSubquestionsPercents((float)$result["total_correct_subquestions_percents"]);
        }

        return $holder;
    }
}