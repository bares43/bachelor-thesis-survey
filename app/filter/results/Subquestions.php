<?php

namespace App\Filter\Results;
use App\Base\Filter;

/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 18. 12. 2015
 * Time: 15:59
 */
class Subquestions extends Filter{

    const ID_RESPONDENTS = "idrespondents";
    const SECONDS = "seconds";
    const DATETIMES = "datetimes";
    const IDS = "IDS";
    const IDS_QUESTIONS = "idsquestions";
    const WEBSITES = "websites";
    const PAGES = "pages";
    const STATE = "state";
    const ANSWER = "answer";
    const REASON = "reason";
    const TYPES = "types";
    const KNOWNS = "knowns";
    CONST ID_WIREFRAMES = "idwireframe";

    /**
     * @param int[] $id_respondents
     */
    public function setIdRespondents($id_respondents) {
        $this->set(self::ID_RESPONDENTS, $id_respondents);
    }

    /**
     * @return int
     */
    public function getIdRespondents() {
        return $this->get(self::ID_RESPONDENTS);
    }

    /**
     * @param int[] $seconds
     */
    public function setSeconds($seconds) {
        $this->set(self::SECONDS, $seconds);
    }

    /**
     * @return int[]
     */
    public function getSeconds() {
        return $this->get(self::SECONDS);
    }

    /**
     * @param string[] $datetimes
     */
    public function setDatetimes($datetimes) {
        $this->set(self::DATETIMES, $datetimes);
    }

    /**
     * @return string[]
     */
    public function getDatetimes() {
        return $this->get(self::DATETIMES);
    }

    /**
     * @param int[] $ids
     */
    public function setIds($ids) {
        $this->set(self::IDS,$ids);
    }

    /**
     * @return int[]
     */
    public function getIds() {
        return $this->get(self::IDS);
    }

    /**
     * @param int[] $ids_questions
     */
    public function setIdsQuestions($ids_questions) {
        $this->set(self::IDS_QUESTIONS, $ids_questions);
    }

    /**
     * @return int[]
     */
    public function getIdsQuestions() {
        return $this->get(self::IDS_QUESTIONS);
    }

    /**
     * @param int[] $websites
     */
    public function setWebsites($websites) {
        $this->set(self::WEBSITES, $websites);
    }

    /**
     * @return int[]
     */
    public function getWebsites() {
        return $this->get(self::WEBSITES);
    }

    /**
     * @param int[] $pages
     */
    public function setPages($pages) {
        $this->set(self::PAGES,$pages);
    }

    /**
     * @return int[]
     */
    public function getPages() {
        return $this->get(self::PAGES);
    }

    /**
     * @param int[] $state
     */
    public function setState($state) {
        $this->set(self::STATE, $state);
    }

    /**
     * @return int[]
     */
    public function getState() {
        return $this->get(self::STATE);
    }

    /**
     * @param string $answer
     */
    public function setAnswer($answer) {
        $this->set(self::ANSWER, $answer);
    }

    /**
     * @return string
     */
    public function getAnswer() {
        return $this->get(self::ANSWER);
    }

    /**
     * @param string $reason
     */
    public function setReason($reason) {
        $this->set(self::REASON, $reason);
    }

    /**
     * @return string
     */
    public function getReason() {
        return $this->get(self::REASON);
    }

    /**
     * @param int[] $types
     */
    public function setTypes($types) {
        $this->set(self::TYPES, $types);
    }

    /**
     * @return int[]
     */
    public function getTypes() {
        return $this->get(self::TYPES);
    }

    /**
     * @param int[] $knowns
     */
    public function setKnowns($knowns) {
        $this->set(self::KNOWNS, $knowns);
    }

    /**
     * @return int[]
     */
    public function getKnowns() {
        return $this->get(self::KNOWNS);
    }

    /**
     * @param int[] $id_wireframe
     */
    public function setIdWireframe($id_wireframe) {
        $this->set(self::ID_WIREFRAMES, $id_wireframe);
    }

    /**
     * @return int[]
     */
    public function getIdWireframe() {
        return $this->get(self::ID_WIREFRAMES);
    }
}