<?php
namespace App\Filter\Results;


use App\Base\Filter;

class Websites extends Filter{

    const IDS_WEBSITES = "idswebsites";
    const SUBQUESTIONS = "subquestions";
    const CORRECT = "correct";
    const ALMOST = "almost";
    const WRONG = "wrong";
    const DISQUALIFIED = "disqualified";
    const PERCENTAGES = "percentages";

    /**
     * @param int[] $ids_websites
     */
    public function setIdsWebsites($ids_websites) {
        $this->set(self::IDS_WEBSITES, $ids_websites);
    }

    /**
     * @return int[]
     */
    public function getIdsWebsites() {
        return $this->get(self::IDS_WEBSITES);
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
     * @param int[] $correct
     */
    public function setCorrect($correct) {
        $this->set(self::CORRECT, $correct);
    }

    /**
     * @return int[]
     */
    public function getCorrect() {
        return $this->get(self::CORRECT);
    }

    /**
     * @param int[] $almost
     */
    public function setAlmost($almost) {
        $this->set(self::ALMOST, $almost);
    }

    /**
     * @return int[]
     */
    public function getAlmost() {
        return $this->get(self::ALMOST);
    }

    /**
     * @param int[] $wrong
     */
    public function setWrong($wrong) {
        $this->set(self::WRONG, $wrong);
    }

    /**
     * @return int[]
     */
    public function getWrong() {
        return $this->get(self::WRONG);
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
     * @param int[] $percentages
     */
    public function setPercentages($percentages) {
        return $this->set(self::PERCENTAGES, $percentages);
    }

    /**
     * @return int[]
     */
    public function getPercentages() {
        return $this->get(self::PERCENTAGES);
    }
}