<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 28. 9. 2015
 * Time: 19:24
 */

namespace App\Holder;


use App\Base\IHolder;
use App\Model\Question;
use App\Model\Subquestion;

class NewQuestion implements IHolder {

    /**
     * @var Question
     */
    private $question;

    /**
     * @var Subquestion
     */
    private $subquestion;

    /**
     * @var Page
     */
    private $page_holder;

    /**
     * @var int
     */
    private $question_type;

    /**
     * @var Page[]
     */
    private $pages_holders;

    /**
     * @var PageRelated
     */
    private $page_related;

    /**
     * @var int
     */
    private $respondent_subquestions_count = 0;

    /**
     * @return Question
     */
    public function getQuestion() {
        return $this->question;
    }

    /**
     * @param Question $question
     */
    public function setQuestion($question) {
        $this->question = $question;
    }

    /**
     * @return Subquestion
     */
    public function getSubquestion() {
        return $this->subquestion;
    }

    /**
     * @param Subquestion $subquestion
     */
    public function setSubquestion($subquestion) {
        $this->subquestion = $subquestion;
    }


    /**
     * @return Page
     */
    public function getPageHolder() {
        return $this->page_holder;
    }

    /**
     * @param Page $page_holder
     */
    public function setPageHolder($page_holder) {
        $this->page_holder = $page_holder;
    }

    /**
     * @return int
     */
    public function getQuestionType() {
        return $this->question_type;
    }

    /**
     * @param int $question_type
     */
    public function setQuestionType($question_type) {
        $this->question_type = $question_type;
    }

    /**
     * @return Page[]
     * @deprecated
     */
    public function getPagesHolders() {
        return $this->pages_holders;
    }

    /**
     * @param Page[] $pages_holders
     * @deprecated
     */
//    public function setPagesHolders($pages_holders) {
//        $this->pages_holders = $pages_holders;
//    }

    /**
     * @return int|null
     */
    public function getQuestionId() {
        if($this->question !== null) return $this->question->id_question;
        return null;
    }

    /**
     * @return int
     */
    public function getRespondentSubquestionsCount() {
        return $this->respondent_subquestions_count;
    }

    /**
     * @param int $respondent_subquestions_count
     */
    public function setRespondentSubquestionsCount($respondent_subquestions_count) {
        $this->respondent_subquestions_count = $respondent_subquestions_count;
    }

    /**
     * @return PageRelated
     */
    public function getPageRelated() {
        return $this->page_related;
    }

    /**
     * @param PageRelated $page_related
     */
    public function setPageRelated($page_related) {
        $this->page_related = $page_related;
    }
}