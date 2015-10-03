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

class NewQuestion implements IHolder {

    /**
     * @var Question
     */
    private $question;

    /**
     * @var Page
     */
    private $page_holder;

    /**
     * @var string
     */
    private $question_type;

    /**
     * @var Page[]
     */
    private $pages_holders;

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
     * @return string
     */
    public function getQuestionType() {
        return $this->question_type;
    }

    /**
     * @param string $question_type
     */
    public function setQuestionType($question_type) {
        $this->question_type = $question_type;
    }

    /**
     * @return Page[]
     */
    public function getPagesHolders() {
        return $this->pages_holders;
    }

    /**
     * @param Page[] $pages_holders
     */
    public function setPagesHolders($pages_holders) {
        $this->pages_holders = $pages_holders;
    }

}