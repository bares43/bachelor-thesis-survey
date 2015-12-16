<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 1. 12. 2015
 * Time: 13:30
 */

namespace App\Holder\Mapper;


use App\Base\IHolder;
use App\Base\IMapper;
use App\Base\Service;
use Nette\Utils\DateTime;

class Highscore implements IMapper{

    /**
     * @param $result
     * @return IHolder
     */
    public function populate($result) {
        $holder = new \App\Holder\Highscore();

        if(isset($result["respondent_id_respondent"])){
            $holder->setRespondent(Service::populateEntity($result, \App\Model\Respondent::getClassName(), "respondent"));
        }

        if(isset($result["date"])){
            $holder->setDate(new DateTime($result["date"]));
        }

        if(isset($result["count_questions"])){
            $holder->setTotalQuestions((int)$result["count_questions"]);
        }

        if(isset($result["count_correct"])){
            $holder->setTotalCorrect((int)$result["count_correct"]);
        }

        if(isset($result["score"])){
            $holder->setScore((float)$result["score"]);
        }

        return $holder;
    }
}