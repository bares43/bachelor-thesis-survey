<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 16:18
 */

namespace App\Holder\Results\Base;


use App\Base\IHolder;

class Respondent implements IHolder{

    /**
     * @var \App\Model\Respondent
     */
    private $respondent;

    /**
     * @var string
     */
    private $age_name;

    /**
     * @var string
     */
    private $gender_name;

    /**
     * @var string
     */
    private $devices_name;

    /**
     * @var string
     */
    private $devicec_most_name;

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
    private $total_unknown_subquestions;

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

    /**
     * @return string
     */
    public function getDevicesName() {
        if($this->devices_name === null && $this->getRespondent() !== null){
            $devices = array();
            if($this->getRespondent()->device_computer) $devices[] = \App\Model\Respondent::DEVICE_COMPUTER;
            if($this->getRespondent()->device_phone) $devices[] = \App\Model\Respondent::DEVICE_PHONE;
            if($this->getRespondent()->device_tablet) $devices[] = \App\Model\Respondent::DEVICE_TABLET;

            $this->devices_name = implode(" / ", $devices);
        }
        return $this->devices_name;
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
    public function getTotalCorrectSubquestionsPercents() {
        if($this->getTotalSubquestions() === 0) return 0;

        return round(($this->getTotalCorrectSubquestions() / $this->getTotalSubquestions())*100,2);
    }
}