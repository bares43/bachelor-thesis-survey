<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 1. 12. 2015
 * Time: 13:28
 */

namespace App\Holder;


use App\Base\IHolder;
use App\Model\Respondent;
use Nette\Utils\DateTime;

class Highscore implements IHolder{

    /**
     * @var Respondent
     */
    private $respondent;

    /**
     * @var int
     */
    private $totalQuestions;

    /**
     * @var int
     */
    private $totalCorrect;

    /**
     * @var DateTime
     */
    private $date;

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
        return $this->totalQuestions;
    }

    /**
     * @param int $totalQuestions
     */
    public function setTotalQuestions($totalQuestions) {
        $this->totalQuestions = $totalQuestions;
    }

    /**
     * @return int
     */
    public function getTotalCorrect() {
        return $this->totalCorrect;
    }

    /**
     * @param int $totalCorrect
     */
    public function setTotalCorrect($totalCorrect) {
        $this->totalCorrect = $totalCorrect;
    }

    /**
     * @return DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate($date) {
        $this->date = $date;
    }
}