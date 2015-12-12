<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 12. 12. 2015
 * Time: 15:46
 */

namespace App\Holder;


use App\Base\IHolder;

class ResultsRespondentsBase implements IHolder{

    /**
     * @var int
     */
    private $total_male;

    /**
     * @var int
     */
    private $total_female;

    /**
     * @var int
     */
    private $total_15;

    /**
     * @var int
     */
    private $total_15_20;

    /**
     * @var int
     */
    private $total_21_30;

    /**
     * @var int
     */
    private $total_31_45;

    /**
     * @var int
     */
    private $total_46_60;

    /**
     * @var int
     */
    private $total_60;

    /**
     * @var int
     */
    private $total_english;

    /**
     * @var int
     */
    private $total_it;

    /**
     * @var int
     */
    private $total_computer;

    /**
     * @var int
     */
    private $total_phone;

    /**
     * @var int
     */
    private $total_tablet;

    /**
     * @var int
     */
    private $total_most_computer;

    /**
     * @var int
     */
    private $total_most_phone;

    /**
     * @var int
     */
    private $total_most_tablet;

    /**
     * @var int
     */
    private $total_most_device_unknown;

    /**
     * @var int
     */
    private $total_gender_unknown;

    /**
     * @var int
     */
    private $total_age_unknown;

    /**
     * @return int
     */
    public function getTotalMale() {
        return $this->total_male;
    }

    /**
     * @param int $total_male
     */
    public function setTotalMale($total_male) {
        $this->total_male = $total_male;
    }

    /**
     * @return int
     */
    public function getTotalFemale() {
        return $this->total_female;
    }

    /**
     * @param int $total_female
     */
    public function setTotalFemale($total_female) {
        $this->total_female = $total_female;
    }

    /**
     * @return int
     */
    public function getTotal15() {
        return $this->total_15;
    }

    /**
     * @param int $total_15
     */
    public function setTotal15($total_15) {
        $this->total_15 = $total_15;
    }

    /**
     * @return int
     */
    public function getTotal1520() {
        return $this->total_15_20;
    }

    /**
     * @param int $total_15_20
     */
    public function setTotal1520($total_15_20) {
        $this->total_15_20 = $total_15_20;
    }

    /**
     * @return int
     */
    public function getTotal2130() {
        return $this->total_21_30;
    }

    /**
     * @param int $total_21_30
     */
    public function setTotal2130($total_21_30) {
        $this->total_21_30 = $total_21_30;
    }

    /**
     * @return int
     */
    public function getTotal3145() {
        return $this->total_31_45;
    }

    /**
     * @param int $total_31_45
     */
    public function setTotal3145($total_31_45) {
        $this->total_31_45 = $total_31_45;
    }

    /**
     * @return int
     */
    public function getTotal4660() {
        return $this->total_46_60;
    }

    /**
     * @param int $total_46_60
     */
    public function setTotal4660($total_46_60) {
        $this->total_46_60 = $total_46_60;
    }

    /**
     * @return int
     */
    public function getTotal60() {
        return $this->total_60;
    }

    /**
     * @param int $total_60
     */
    public function setTotal60($total_60) {
        $this->total_60 = $total_60;
    }

    /**
     * @return int
     */
    public function getTotalEnglish() {
        return $this->total_english;
    }

    /**
     * @param int $total_english
     */
    public function setTotalEnglish($total_english) {
        $this->total_english = $total_english;
    }

    /**
     * @return int
     */
    public function getTotalIt() {
        return $this->total_it;
    }

    /**
     * @param int $total_it
     */
    public function setTotalIt($total_it) {
        $this->total_it = $total_it;
    }

    /**
     * @return int
     */
    public function getTotalComputer() {
        return $this->total_computer;
    }

    /**
     * @param int $total_computer
     */
    public function setTotalComputer($total_computer) {
        $this->total_computer = $total_computer;
    }

    /**
     * @return int
     */
    public function getTotalPhone() {
        return $this->total_phone;
    }

    /**
     * @param int $total_phone
     */
    public function setTotalPhone($total_phone) {
        $this->total_phone = $total_phone;
    }

    /**
     * @return int
     */
    public function getTotalTablet() {
        return $this->total_tablet;
    }

    /**
     * @param int $total_tablet
     */
    public function setTotalTablet($total_tablet) {
        $this->total_tablet = $total_tablet;
    }

    /**
     * @return int
     */
    public function getTotalMostComputer() {
        return $this->total_most_computer;
    }

    /**
     * @param int $total_most_computer
     */
    public function setTotalMostComputer($total_most_computer) {
        $this->total_most_computer = $total_most_computer;
    }

    /**
     * @return int
     */
    public function getTotalMostPhone() {
        return $this->total_most_phone;
    }

    /**
     * @param int $total_most_phone
     */
    public function setTotalMostPhone($total_most_phone) {
        $this->total_most_phone = $total_most_phone;
    }

    /**
     * @return int
     */
    public function getTotalMostTablet() {
        return $this->total_most_tablet;
    }

    /**
     * @param int $total_most_tablet
     */
    public function setTotalMostTablet($total_most_tablet) {
        $this->total_most_tablet = $total_most_tablet;
    }

    /**
     * @return int
     */
    public function getTotalGenderUnknown() {
        return $this->total_gender_unknown;
    }

    /**
     * @param int $total_gender_unknown
     */
    public function setTotalGenderUnknown($total_gender_unknown) {
        $this->total_gender_unknown = $total_gender_unknown;
    }

    /**
     * @return int
     */
    public function getTotalAgeUnknown() {
        return $this->total_age_unknown;
    }

    /**
     * @param int $total_age_unknown
     */
    public function setTotalAgeUnknown($total_age_unknown) {
        $this->total_age_unknown = $total_age_unknown;
    }

    /**
     * @return int
     */
    public function getTotalMostDeviceUnknown() {
        return $this->total_most_device_unknown;
    }

    /**
     * @param int $total_most_device_unknown
     */
    public function setTotalMostDeviceUnknown($total_most_device_unknown) {
        $this->total_most_device_unknown = $total_most_device_unknown;
    }


}