<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 16:18
 */

namespace App\Holder;


use App\Base\IHolder;
use App\Model\Respondent;

class ResultsRespondent implements IHolder{

    /**
     * @var Respondent
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

    private $total_questions;

    private $total_subquestions;

    private $total_correct_subquestions;

    private $total_wrong_subquestions;

    private $total_unknown_subquestions;

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
     * @return string
     */
    public function getAgeName() {
        if($this->age_name === null && $this->getRespondent() !== null){
            switch($this->getRespondent()->gender){
                case Respondent::AGE_15: $this->age_name = "< 15"; break;
                case Respondent::AGE_15_20: $this->age_name = "15-20"; break;
                case Respondent::AGE_21_30: $this->age_name = "21-30"; break;
                case Respondent::AGE_31_45: $this->age_name = "31-45"; break;
                case Respondent::AGE_46_60: $this->age_name = "46-60"; break;
                case Respondent::AGE_60: $this->age_name = "> 60"; break;
//                default: $this->age_name = "neznámé";
            }
        }
        return $this->age_name;
    }

    /**
     * @return string
     */
    public function getGenderName() {
        if($this->gender_name === null && $this->getRespondent() !== null){
            switch($this->getRespondent()->gender){
                case Respondent::GENDER_MALE: $this->gender_name = "muž"; break;
                case Respondent::GENDER_FEMALE: $this->gender_name = "žena"; break;
//                default: $this->gender_name = "neznámé";
            }
        }
        return $this->gender_name;
    }

    /**
     * @return string
     */
    public function getDevicesName() {
        if($this->devices_name === null && $this->getRespondent() !== null){
            $devices = array();
            if($this->getRespondent()->device_computer) $devices[] = Respondent::DEVICE_COMPUTER;
            if($this->getRespondent()->device_phone) $devices[] = Respondent::DEVICE_PHONE;
            if($this->getRespondent()->device_tablet) $devices[] = Respondent::DEVICE_TABLET;

            $this->devices_name = implode(" / ", $devices);
        }
        return $this->devices_name;
    }

    /**
     * @return string
     */
    public function getDevicecMostName() {
        if($this->devicec_most_name === null && $this->getRespondent() !== null){
            $this->devicec_most_name = $this->getRespondent()->device_most;
        }
        return $this->devicec_most_name;
    }

    /**
     * @return mixed
     */
    public function getTotalQuestions() {
        return $this->total_questions;
    }

    /**
     * @param mixed $total_questions
     */
    public function setTotalQuestions($total_questions) {
        $this->total_questions = $total_questions;
    }

    /**
     * @return mixed
     */
    public function getTotalSubquestions() {
        return $this->total_subquestions;
    }

    /**
     * @param mixed $total_subquestions
     */
    public function setTotalSubquestions($total_subquestions) {
        $this->total_subquestions = $total_subquestions;
    }

    /**
     * @return mixed
     */
    public function getTotalCorrectSubquestions() {
        return $this->total_correct_subquestions;
    }

    /**
     * @param mixed $total_correct_subquestions
     */
    public function setTotalCorrectSubquestions($total_correct_subquestions) {
        $this->total_correct_subquestions = $total_correct_subquestions;
    }

    /**
     * @return mixed
     */
    public function getTotalWrongSubquestions() {
        return $this->total_wrong_subquestions;
    }

    /**
     * @param mixed $total_wrong_subquestions
     */
    public function setTotalWrongSubquestions($total_wrong_subquestions) {
        $this->total_wrong_subquestions = $total_wrong_subquestions;
    }

    /**
     * @return mixed
     */
    public function getTotalUnknownSubquestions() {
        return $this->total_unknown_subquestions;
    }

    /**
     * @param mixed $total_unknown_subquestions
     */
    public function setTotalUnknownSubquestions($total_unknown_subquestions) {
        $this->total_unknown_subquestions = $total_unknown_subquestions;
    }

}