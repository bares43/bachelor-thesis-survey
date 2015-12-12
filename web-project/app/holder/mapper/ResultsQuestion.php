<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 17:34
 */

namespace App\Holder\Mapper;


use App\Base\IHolder;
use App\Base\IMapper;
use App\Base\Service;

class ResultsQuestion implements IMapper{

    /**
     * @param $result
     * @return IHolder
     */
    public function populate($result) {
        $holder = new \App\Holder\ResultsQuestion();


        if(isset($result["question_id_question"])){
            $holder->setQuestion(Service::populateEntity($result, \App\Model\Question::getClassName(), "question"));
        }
        if(isset($result["subquestion_id_subquestion"])){
            $holder->setSubquestion(Service::populateEntity($result, \App\Model\Subquestion::getClassName(), "subquestion"));
        }
        if(isset($result["page_id_page"])){
            $holder->setPage(Service::populateEntity($result, \App\Model\Page::getClassName(), "page"));
        }
        if(isset($result["website_id_website"])){
            $holder->setWebsite(Service::populateEntity($result, \App\Model\Website::getClassName(), "website"));
        }
        if(isset($result["respondent_website_id_respondent_website"])){
            $holder->setRespondentWebsite(Service::populateEntity($result, \App\Model\RespondentWebsite::getClassName(), "respondent_website"));
        }


        return $holder;
    }
}