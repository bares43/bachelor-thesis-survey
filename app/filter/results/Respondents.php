<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 19. 12. 2015
 * Time: 16:23
 */

namespace App\Filter\Results;


use App\Base\Filter;
use App\Utils\Arr;

class Respondents extends Filter{

    const ID_RESPONDENTS = "idrespondents";
    const DATETIMES = "datetimes";
    const AGES = "ages";
    const GENDERS = "genders";
    const ENGLISH = "english";
    const IT = "it";
    const DEVICES = "devices";
    const DEVICES_MOST = "devicesmost";
    const WEBSITES = "websites";
    const QUESTIONS = "questions";
    const SUBQUESTIONS = "subquestions";
    const CORRECTS = "corrects";
    const WRONGS = "wrongs";
    const ALMOSTS = "almosts";
    const UNKNOWNS = "unknowns";
    const DISQUALIFIED = "disqualified";
    const PERCENTAGES = "percentages";

    /**
     * @param int[] $respondents
     */
    public function setRespondents($respondents) {
        $this->set(self::ID_RESPONDENTS, $respondents);
    }

    /**
     * @return int[]
     */
    public function getRespondents() {
        return $this->get(self::ID_RESPONDENTS);
    }

    /**
     * @param string[] $datetimes
     */
    public function setDatetimes($datetimes) {
        if(Arr::is_assoc($datetimes)){
            $datetimes = array_map(function($item){
                return "'$item'";
            },$datetimes);
        }
        $this->set(self::DATETIMES, $datetimes);
    }

    /**
     * @return string[]
     */
    public function getDatetimes() {
        return $this->get(self::DATETIMES);
    }

    /**
     * @param string[] $ages
     */
    public function setAges($ages) {
        $this->set(self::AGES,$ages);
    }

    /**
     * @return string[]
     */
    public function getAges() {
        return $this->get(self::AGES);
    }

    /**
     * @param string[] $genders
     */
    public function setGenders($genders) {
        $this->set(self::GENDERS, $genders);
    }

    /**
     * @return string[]
     */
    public function getGenders() {
        return $this->get(self::GENDERS);
    }

    /**
     * @param int[] $englishes
     */
    public function setEnglishes($englishes) {
        $this->set(self::ENGLISH, $englishes);
    }

    /**
     * @return int[]
     */
    public function getEnglishes() {
        return $this->get(self::ENGLISH);
    }

    /**
     * @param int[] $its
     */
    public function setIts($its) {
        $this->set(self::IT, $its);
    }

    /**
     * @return int[]
     */
    public function getIts() {
        return $this->get(self::IT);
    }

    /**
     * @param string[] $devices
     */
    public function setDevices($devices) {
        $this->set(self::DEVICES, $devices);
    }

    /**
     * @return string[]
     */
    public function getDevices() {
        return $this->get(self::DEVICES);
    }

    /**
     * @param string[] $devicesMost
     */
    public function setDevicesMost($devicesMost) {
        $this->set(self::DEVICES_MOST, $devicesMost);
    }

    /**
     * @return string[]
     */
    public function getDevicesMost() {
        return $this->get(self::DEVICES_MOST);
    }

    /**
     * @param sring $websites
     */
    public function setWebsites($websites) {
        $this->set(self::WEBSITES, $websites);
    }

    /**
     * @return string
     */
    public function getWebsites() {
        return $this->get(self::WEBSITES);
    }

    /**
     * @param int[] $questions
     */
    public function setQuestions($questions) {
        $this->set(self::QUESTIONS, $questions);
    }

    /**
     * @return int[]
     */
    public function getQuestions() {
        return $this->get(self::QUESTIONS);
    }

    /**
     * @param int[] $subquestions
     */
    public function setSubquestions($subquestions) {
        $this->set(self::SUBQUESTIONS, $subquestions);
    }

    /**
     * @return int[]
     */
    public function getSubquestions() {
        return $this->get(self::SUBQUESTIONS);
    }

    /**
     * @param int[] $corrects
     */
    public function setCorrects($corrects) {
        $this->set(self::CORRECTS, $corrects);
    }

    /**
     * @return int[]
     */
    public function getCorrects() {
        return $this->get(self::CORRECTS);
    }

    /**
     * @param int[] $wrongs
     */
    public function setWrongs($wrongs) {
        $this->set(self::WRONGS, $wrongs);
    }

    /**
     * @return int[]
     */
    public function getWrongs() {
        return $this->get(self::WRONGS);
    }

    /**
     * @param int[] $unknowns
     */
    public function setUnknowns($unknowns) {
        $this->set(self::UNKNOWNS, $unknowns);
    }

    /**
     * @return int[]
     */
    public function getUnknowns() {
        return $this->get(self::UNKNOWNS);
    }

    /**
     * @param int[] $almosts
     */
    public function setAlmosts($almosts) {
        $this->set(self::ALMOSTS, $almosts);
    }

    /**
     * @return int[]
     */
    public function getAlmosts() {
        return $this->get(self::ALMOSTS);
    }

    /**
     * @param int[] $disqualified
     */
    public function setDisqualified($disqualified) {
        $this->set(self::DISQUALIFIED, $disqualified);
    }

    /**
     * @return int[]
     */
    public function getDisqualified() {
        return $this->get(self::DISQUALIFIED);
    }

    /**
     * @param float[] $percentages
     */
    public function setPercentages($percentages) {
        $this->set(self::PERCENTAGES, $percentages);
    }

    /**
     * @return float[]
     */
    public function getPercentages() {
        return $this->get(self::PERCENTAGES);
    }
}