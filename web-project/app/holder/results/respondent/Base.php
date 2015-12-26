<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 16. 12. 2015
 * Time: 0:21
 */

namespace App\Holder\Results\Respondent;


use App\Base\IHolder;
use App\Model\Respondent;

class Base implements IHolder{

    /**
     * @var Respondent;
     */
    private $respondent;

    /**
     * @var int
     */
    private $total_questions;

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
    private $total_wrong_subquestions;

    /**
     * @var int
     */
    private $total_almost_subquestions;

    /**
     * @var int
     */
    private $total_disqualified_subquestions;

    /**
     * @var int
     */
    private $total_unknown_subquestions;

    /**
     * @var float
     */
    private $avg_seconds;

    /**
     * @var int
     */
    private $total_seconds;

    /**
     * @var float
     */
    private $total_correct_subquestions_percents;

    /**
     * @return Respondent
     */
    public function getRespondent() {
        return $this->respondent;
    }

    /**
     * @param Respondent $respondent
     */
    public function setRespondent($respondent) {
        $this->respondent = $respondent;
    }

    /**
     * @return int
     */
    public function getTotalQuestions() {
        return $this->total_questions;
    }

    /**
     * @param int $total_questions
     */
    public function setTotalQuestions($total_questions) {
        $this->total_questions = $total_questions;
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
    public function getTotalUnknownSubquestions() {
        return $this->total_unknown_subquestions;
    }

    /**
     * @param int $total_unknown_subquestions
     */
    public function setTotalUnknownSubquestions($total_unknown_subquestions) {
        $this->total_unknown_subquestions = $total_unknown_subquestions;
    }

    /**
     * @return float
     */
    public function getAvgSeconds() {
        return $this->avg_seconds;
    }

    /**
     * @param float $avg_seconds
     */
    public function setAvgSeconds($avg_seconds) {
        $this->avg_seconds = $avg_seconds;
    }

    /**
     * @return int
     */
    public function getTotalSeconds() {
        return $this->total_seconds;
    }

    /**
     * @param int $total_seconds
     */
    public function setTotalSeconds($total_seconds) {
        $this->total_seconds = $total_seconds;
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
    public function getTotalDisqualifiedSubquestions() {
        return $this->total_disqualified_subquestions;
    }

    /**
     * @param int $total_disqualified_subquestions
     */
    public function setTotalDisqualifiedSubquestions($total_disqualified_subquestions) {
        $this->total_disqualified_subquestions = $total_disqualified_subquestions;
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


}