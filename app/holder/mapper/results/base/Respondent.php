<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 16:19
 */

namespace App\Holder\Mapper\Results\Base;


use App\Base\IHolder;
use App\Base\IMapper;
use App\Base\Service;

class Respondent implements IMapper{

    /**
     * @param $result
     * @return IHolder
     */
    public function populate($result) {
        $holder = new \App\Holder\Results\Base\Respondent();


        if(isset($result["respondent_id_respondent"])){
            $holder->setRespondent(Service::populateEntity($result, \App\Model\Respondent::getClassName(), "respondent"));
        }

        if(isset($result["total_questions"])){
            $holder->setTotalQuestions((int)$result["total_questions"]);
        }
        if(isset($result["total_subquestions"])){
            $holder->setTotalSubquestions((int)$result["total_subquestions"]);
        }
        if(isset($result["total_correct_subquestions"])){
            $holder->setTotalCorrectSubquestions((int)$result["total_correct_subquestions"]);
        }
        if(isset($result["total_wrong_subquestions"])){
            $holder->setTotalWrongSubquestions((int)$result["total_wrong_subquestions"]);
        }
        if(isset($result["total_almost_subquestions"])){
            $holder->setTotalAlmostSubquestions((int)$result["total_almost_subquestions"]);
        }
        if(isset($result["total_unknown_subquestions"])){
            $holder->setTotalUnknownSubquestions((int)$result["total_unknown_subquestions"]);
        }
        if(isset($result["total_disqualified_subquestions"])){
            $holder->setTotalDisqualifiedSubquestions((int)$result["total_disqualified_subquestions"]);
        }

        if(isset($result["total_correct_subquestions_percents"])){
            $holder->setTotalCorrectSubquestionsPercents((float)$result["total_correct_subquestions_percents"]);
        }



        return $holder;
    }
}