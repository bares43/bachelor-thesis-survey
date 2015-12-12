<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 17:32
 */

namespace App\Holder;


use App\Base\IHolder;
use App\Model\Question;
use App\Model\RespondentWebsite;
use App\Model\Subquestion;

class ResultsQuestion implements IHolder{

    /**
     * @var Question
     */
    private $question;

    /**
     * @var Subquestion
     */
    private $subquestion;

    /**
     * @var \App\Model\Page
     */
    private $page;

    /**
     * @var \App\Model\Website
     */
    private $website;

    /**
     * @var RespondentWebsite
     */
    private $respondent_website;

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
     * @return \App\Model\Page
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * @param \App\Model\Page $page
     */
    public function setPage($page) {
        $this->page = $page;
    }

    /**
     * @return \App\Model\Website
     */
    public function getWebsite() {
        return $this->website;
    }

    /**
     * @param \App\Model\Website $website
     */
    public function setWebsite($website) {
        $this->website = $website;
    }

    /**
     * @return RespondentWebsite
     */
    public function getRespondentWebsite() {
        return $this->respondent_website;
    }

    /**
     * @param RespondentWebsite $respondent_website
     */
    public function setRespondentWebsite($respondent_website) {
        $this->respondent_website = $respondent_website;
    }

}