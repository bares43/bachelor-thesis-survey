<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 5. 11. 2015
 * Time: 14:53
 */

namespace App\Holder;


use App\Base\IHolder;

class PageRelated implements IHolder {

    /**
     * @var \App\Model\PageRelated
     */
    private $page_related;

    /**
     * @var Page
     */
    private $page_a;

    /**
     * @var Page
     */
    private $page_b;

    /** @var Page[] */
    private $pages_as_array = array();

    /**
     * @return \App\Model\PageRelated
     */
    public function getPageRelated() {
        return $this->page_related;
    }

    /**
     * @param \App\Model\PageRelated $page_related
     */
    public function setPageRelated($page_related) {
        $this->page_related = $page_related;
    }

    /**
     * @return Page
     */
    public function getPageA() {
        return $this->page_a;
    }

    /**
     * @param Page $page_a
     */
    public function setPageA($page_a) {
        $this->page_a = $page_a;
    }

    /**
     * @return Page
     */
    public function getPageB() {
        return $this->page_b;
    }

    /**
     * @param Page $page_b
     */
    public function setPageB($page_b) {
        $this->page_b = $page_b;
    }

    /**
     * @return Page[]
     */
    public function getPagesRelatedAsArray() {
        if(count($this->pages_as_array) === 0){
            if($this->page_a !== null && $this->page_b !== null){
                $pages[] = $this->page_a;
                $pages[] = $this->page_b;

                shuffle($pages);

                $this->pages_as_array = $pages;
            }
        }
        return $this->pages_as_array;
    }
}