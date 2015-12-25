<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 14:05
 */

namespace App\Holder\Results\Base;


use App\Base\IHolder;

class Base implements IHolder{

    /**
     * @var int
     */
    private $total_respondents;

    /**
     * @var int
     */
    private $total_questions;

    /**
     * @var float
     */
    private $avg_questions;

    /**
     * @var int
     */
    private $total_subquestions;

    /**
     * @var int
     */
    private $total_correct_subeustions;

    /**
     * @var int
     */
    private $total_wrong_subquestions;

    /**
     * @var int
     */
    private $total_almost_subquestions;

    /** @var  int */
    private $total_null_subquestions;

    /**
     * @var float
     */
    private $avg_subquestions;

    /**
     * @var float
     */
    private $avg_seconds;

    /**
     * @var float
     */
    private $avg_success;

    /**
     * @return int
     */
    public function getTotalRespondents() {
        return $this->total_respondents;
    }

    /**
     * @param int $total_respondents
     */
    public function setTotalRespondents($total_respondents) {
        $this->total_respondents = $total_respondents;
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
     * @return float
     */
    public function getAvgQuestions() {
        return $this->avg_questions;
    }

    /**
     * @param float $avg_questions
     */
    public function setAvgQuestions($avg_questions) {
        $this->avg_questions = $avg_questions;
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
    public function getTotalCorrectSubeustions() {
        return $this->total_correct_subeustions;
    }

    /**
     * @param int $total_correct_subeustions
     */
    public function setTotalCorrectSubeustions($total_correct_subeustions) {
        $this->total_correct_subeustions = $total_correct_subeustions;
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
    public function getTotalNullSubquestions() {
        return $this->total_null_subquestions;
    }

    /**
     * @param int $total_null_subquestions
     */
    public function setTotalNullSubquestions($total_null_subquestions) {
        $this->total_null_subquestions = $total_null_subquestions;
    }

    /**
     * @return float
     */
    public function getAvgSubquestions() {
        return $this->avg_subquestions;
    }

    /**
     * @param float $avg_subquestions
     */
    public function setAvgSubquestions($avg_subquestions) {
        $this->avg_subquestions = $avg_subquestions;
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
     * @return float
     */
    public function getAvgSuccess() {
        return $this->avg_success;
    }

    /**
     * @param float $avg_success
     */
    public function setAvgSuccess($avg_success) {
        $this->avg_success = $avg_success;
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

}