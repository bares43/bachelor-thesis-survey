<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 14. 12. 2015
 * Time: 1:19
 */

namespace App\Holder\Results\Base;


use App\Base\IHolder;
use App\Model\Website;

class Page implements IHolder{

    /**
     * @var \App\Model\Page
     */
    private $page;

    /**
     * @var  Website
     */
    private $website;

    /**
     * @var int
     */
    private $total_subquestions;

    /**
     * @var int
     */
    private $total_correct_subquestions;

    /**
     * @var int
     */
    private $total_almost_subquestions;

    /**
     * @var int
     */
    private $total_wrong_subquestions;

    /**
     * @var int
     */
    private $total_disqualified_subquestions;

    /**
     * @var float
     */
    private $total_correct_subquestions_percents;

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
     * @return int
     */
    public function getTotalSubquestions() {
        return $this->total_subquestions;
    }

    /**
     * @param int $total_subquestions
     */
    public function setTotalSubquestions($total_subquestions) {
        $this->total_subquestions = $total_subquestions;
    }

    /**
     * @return int
     */
    public function getTotalCorrectSubquestions() {
        return $this->total_correct_subquestions;
    }

    /**
     * @param int $total_correct_subquestions
     */
    public function setTotalCorrectSubquestions($total_correct_subquestions) {
        $this->total_correct_subquestions = $total_correct_subquestions;
    }

    /**
     * @return float
     */
    public function getTotalCorrectSubquestionsPercents() {
        return $this->total_correct_subquestions_percents !== null ? $this->total_correct_subquestions_percents : 0;
    }

    /**
     * @param float $total_correct_subquestions_percents
     */
    public function setTotalCorrectSubquestionsPercents($total_correct_subquestions_percents) {
        $this->total_correct_subquestions_percents = $total_correct_subquestions_percents;
    }

    /**
     * @return int
     */
    public function getTotalAlmostSubquestions() {
        return $this->total_almost_subquestions;
    }

    /**
     * @param int $total_almost_subquestions
     */
    public function setTotalAlmostSubquestions($total_almost_subquestions) {
        $this->total_almost_subquestions = $total_almost_subquestions;
    }

    /**
     * @return int
     */
    public function getTotalWrongSubquestions() {
        return $this->total_wrong_subquestions;
    }

    /**
     * @param int $total_wrong_subquestions
     */
    public function setTotalWrongSubquestions($total_wrong_subquestions) {
        $this->total_wrong_subquestions = $total_wrong_subquestions;
    }

    /**
     * @return int
     */
    public function getTotalDisqualifiedSubquestions() {
        return $this->total_disqualified_subquestions;
    }

    /**
     * @param int $total_disqualified_subquestions
     */
    public function setTotalDisqualifiedSubquestions($total_disqualified_subquestions) {
        $this->total_disqualified_subquestions = $total_disqualified_subquestions;
    }

}