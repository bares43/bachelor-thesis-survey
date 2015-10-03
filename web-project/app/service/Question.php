<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:29
 */

namespace App\Service;


use App\Base\Service;
use App\Holder\NewQuestion;
use App\Service\Page;
use App\Service\Subquestion;
use App\Service\Website;

class Question extends Service {

    /** @var \App\Database\Question */
    private $database;

    /** @var Page */
    private $page_service;

    /**
     * Question constructor.
     * @param \App\Database\Question $db_question
     * @param Page $page_service
     */
    public function __construct(\App\Database\Question $db_question, Page $page_service) {
        $this->database = $db_question;
        $this->page_service = $page_service;
    }

    /**
     * @param $id_question
     * @return \App\Model\Question|null
     */
    public function get($id_question) {
        return $this->database->get($id_question);
    }

    /**
     * @return \App\Model\Question[]
     */
    public function getAll() {
        return $this->database->getAll();
    }

    /**
     * @param \App\Model\Question $question
     */
    public function save($question) {
        $this->database->save($question);
    }

    /**
     * @param int $id_respondent
     * @param int $id_page
     * @return \App\Model\Question
     */
    public function create($id_respondent, $id_page) {
        return $this->database->create($id_respondent, $id_page);
    }

    /**
     * @param \App\Model\Respondent|null $respondent
     * @return NewQuestion
     */
    public function generateNewQuestion($respondent) {
        $new_question = new NewQuestion();

        $options_wireframes = array(
            \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME=>0,
            \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_SELECT=>0,
            \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE=>0
        );
        $options_colors = array(
            \App\Model\Subquestion::QUESTION_TYPE_COLOR=>0,
            \App\Model\Subquestion::QUESTION_TYPE_COLOR_SELECT=>0
        );
        $options = array_merge($options_wireframes, $options_colors);

        $filter = new \App\Filter\Page;

        $last_question = null;

        /** @var \App\Model\Page $page */
        $page = null;
        /** @var \App\Model\Wireframe $wireframe */
        $wireframe = null;
        $question_type = null;
        /** @var \App\Model\Question $question */
        $question = null;

        $page_holder = null;

        if($respondent !== null){

            // nastaveni jazyka do filtru
            $languages = array(\App\Model\Website::LANGUAGE_CZECH);
            if($respondent->english) $languages[] = \App\Model\Website::LANGUAGE_ENGLISH;
            $filter->setLanguages($languages);

            // nastavit kategorie do filtru

            // nastavit zarizeni do filtru

            /** @var \App\Holder\Subquestion[] $subquestions */
            $subquestions = $this->getSubquestionHoldersByIdRespondent($respondent->id_respondent);

            $rand = rand(1,100);

            if(count($subquestions) > 0) {

                $pages_ids = array();
                foreach($subquestions as $holder){
                    $pages_ids[] = $holder->getPage()->id_page;

                    $options[$holder->getSubquestion()->question_type]++;
                }
                $pages_ids_part = array_slice($pages_ids,ceil(count($pages_ids)/2));
                $pages_ids = array_unique($pages_ids);
                arsort($options);

                /** @var \App\Holder\Subquestion $last_subquestion */
                $last_subquestion = end($subquestions);

                /** Poslední page, pokud byla zodpovězena špatně, jen s jiným typem otázky */
                if ($rand >= 1 && $rand <= 20 && $last_subquestion->getSubquestion()->correct !== null && !$last_subquestion->getSubquestion()->correct) {
                    $page = $last_subquestion->getPage();
                    if(in_array($last_subquestion->getSubquestion()->question_type,array_keys($options_wireframes))){
                        $question_type = array_rand($options_colors);
                    }else{
                        $question_type = array_rand($options_wireframes);
                    }
                    $question = $last_subquestion->getQuestion();
                }
                /** Page která již byla zobrazena s jiným typem otázky */
                else if ($rand >= 80 && $rand <= 100) {
                }
                /** Náhodná prioritní page, kromě již zobrazených, nerespektuji nastavneí responenta */
                else if($rand >= 21 && $rand <= 35){
                    $page_holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                        array(
                            \App\Filter\Page::PRIORITY=>true,
                            \App\Filter\Page::EXCLUDE_ID_PAGE=>$pages_ids
                        )
                    ));
                    $question_type = array_rand($options_wireframes);
                }

                /** Náhodná page kromě X posledních pages, respektovat nastavení respondenta */
                if($page === null){
                    $page_holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                        array(
                            \App\Filter\Page::PRIORITY=>true,
                            \App\Filter\Page::EXCLUDE_ID_PAGE=>$pages_ids_part
                        )
                    ));
                    $question_type = array_rand($options_wireframes);
                }
            }
            /** Náhodná prioritní page, respektuji nastavení respondenta */
            else{
                $page_holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                    array(\App\Filter\Page::PRIORITY=>true)
                ));
                $question_type = array_rand($options_wireframes);
            }
        }

        /** Náhodná prioritní page s nádhoným typem otázky, kromě otázek na barvy */
        if($page_holder === null){
            $page_holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                array(\App\Filter\Page::PRIORITY=>true)
            ));
            $question_type = array_rand($options_wireframes);
        }

        switch($question_type){
            case \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_SELECT:
                $question_type_string = "wireframeselect";
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE:
                $question_type_string = "wireframereverse";
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_COLOR:
                $question_type_string = "color";
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_COLOR_SELECT:
                $question_type_string = "colorselect";
                break;
            default:
                $question_type_string = "wireframe";
        }

        $new_question->setQuestion($question);
        $new_question->setPageHolder($page_holder);
        $new_question->setQuestionType($question_type_string);



        return $new_question;
    }

    /**
     * @param int $id_respondent
     * @return \App\Holder\Subquestion[]
     */
    public function getSubquestionHoldersByIdRespondent($id_respondent) {
        return $this->database->getSubquestionHoldersByIdRespondent($id_respondent);
    }
}