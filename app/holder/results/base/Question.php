<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 17:32
 */

namespace App\Holder\Results\Base;


use App\Base\IHolder;
use App\Model\RespondentWebsite;
use App\Model\Subquestion;

class Question implements IHolder{

    /**
     * @var \App\Model\Question
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

    /** @var  \App\Model\Respondent */
    private $respondent;

    /**
     * @return \App\Model\Question
     */
    public function getQuestion() {
        return $this->question;
    }

    /**
     * @param \App\Model\Question $question
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

    /**
     * @return \App\Model\Respondent
     */
    public function getRespondent() {
        return $this->respondent;
    }

    /**
     * @param \App\Model\Respondent $respondent
     */
    public function setRespondent($respondent) {
        $this->respondent = $respondent;
    }

}