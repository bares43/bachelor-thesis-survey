<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 9. 2015
 * Time: 20:47
 */

namespace App\Holder\Mapper;

use App\Base\Database;
use App\Base\IMapper;
use App\Base\Service;
use App\Model\Page;
use App\Model\Question;
use App\Model\Website;
use App\Model\Wireframe;

class Subquestion implements IMapper {

    /**
     * @param $result
     * @return \App\Holder\Subquestion
     */
    public function populate($result) {
        $holder = new \App\Holder\Subquestion();

        if(isset($result["wireframe_id_wireframe"])){
            $holder->setWireframe(Service::populateEntity($result, Wireframe::getClassName(), "wireframe"));
        }

        if(isset($result["subquestion_id_subquestion"])){
            $holder->setSubquestion(Service::populateEntity($result, \App\Model\Subquestion::getClassName(), "subquestion"));
        }

        if(isset($result["question_id_question"])){
            $holder->setQuestion(Service::populateEntity($result, Question::getClassName(), "question"));
        }

        if(isset($result["page_id_page"])){
            $holder->setPage(Service::populateEntity($result, Page::getClassName(), "page"));
        }

        if(isset($result["website_id_website"])){
            $holder->setWebsite(Service::populateEntity($result, Website::getClassName(), "website"));
        }

        return $holder;
    }
}