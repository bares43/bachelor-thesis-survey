<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 14. 12. 2015
 * Time: 1:19
 */

namespace App\Holder;


use App\Base\IHolder;
use App\Model\Page;
use App\Model\Website;

class ResultsPage implements IHolder{

    /**
     * @var Page
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
     * @return Page
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * @param Page $page
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

    public function getTotalCorrectSubquestionsPercentages() {
        if($this->getTotalSubquestions() === 0) return 0;

        return round(($this->getTotalCorrectSubquestions() / $this->getTotalSubquestions())*100,2);
    }
}