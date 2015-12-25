<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 14:11
 */

namespace App\Holder\Mapper\Results\Base;


use App\Base\IHolder;
use App\Base\IMapper;

class Base implements IMapper{

    /**
     * @param $result
     * @return IHolder
     */
    public function populate($result) {
        $holder = new \App\Holder\Results\Base\Base();

        if(isset($result["total_respondents"])){
            $holder->setTotalRespondents((int)$result["total_respondents"]);
        }
        if(isset($result["total_questions"])){
            $holder->setTotalQuestions((int)$result["total_questions"]);
        }
        if(isset($result["total_subquestions"])){
            $holder->setTotalSubquestions((int)$result["total_subquestions"]);
        }
        if(isset($result["total_correct_subquestions"])){
            $holder->setTotalCorrectSubeustions((int)$result["total_correct_subquestions"]);
        }
        if(isset($result["total_wrong_subquestions"])){
            $holder->setTotalWrongSubquestions((int)$result["total_wrong_subquestions"]);
        }
        if(isset($result["total_almost_subquestions"])){
            $holder->setTotalAlmostSubquestions((int)$result["total_almost_subquestions"]);
        }
        if(isset($result["avg_seconds"])){
            $holder->setAvgSeconds((float)$result["avg_seconds"]);
        }
        return $holder;
    }
}