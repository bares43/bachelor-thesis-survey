<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 9. 2015
 * Time: 20:46
 */

namespace App\Holder;


use App\Base\IHolder;
use App\Model\Question;
use App\Model\Website;
use App\Model\Wireframe;

class Subquestion implements IHolder {

    /** @var \App\Model\Subquestion */
    private $subquestion;

    /** @var Question */
    private $question;

    /** @var \App\Model\Page */
    private $page;

    /** @var Website */
    private $website;

    /** @var Wireframe */
    private $wireframe;

    /**
     * @return \App\Model\Subquestion
     */
    public function getSubquestion() {
        return $this->subquestion;
    }

    /**
     * @param \App\Model\Subquestion $subquestion
     */
    public function setSubquestion($subquestion) {
        $this->subquestion = $subquestion;
    }

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
     * @return Website
     */
    public function getWebsite() {
        return $this->website;
    }

    /**
     * @param Website $website
     */
    public function setWebsite($website) {
        $this->website = $website;
    }

    /**
     * @return Wireframe
     */
    public function getWireframe() {
        return $this->wireframe;
    }

    /**
     * @param Wireframe $wireframe
     */
    public function setWireframe($wireframe) {
        $this->wireframe = $wireframe;
    }
}