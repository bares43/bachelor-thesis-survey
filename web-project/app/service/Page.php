<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:28
 */

namespace App\Service;


use App\Base\Service;
use App\Database\PageRelated;

class Page extends Service {

    /** @var \App\Database\Page */
    private $database;

    /** @var PageRelated */
    private $page_related_database;

    /**
     * Page constructor.
     * @param \App\Database\Page $db_pages
     * @param PageRelated $db_page_related
     */
    public function __construct(\App\Database\Page $db_pages, PageRelated $db_page_related) {
        $this->database = $db_pages;
        $this->page_related_database = $db_page_related;
    }

    /**
     * @param $id_page
     * @return \App\Model\Page|null
     */
    public function get($id_page) {
        return $this->database->get($id_page);
    }

    /**
     * @return \App\Model\Page[]
     */
    public function getAll() {
        return $this->database->getAll();
    }

    /**
     * @param \App\Model\Page $page
     */
    public function save($page) {
        $this->database->save($page);
    }

    /**
     * @param \App\Filter\Page $filter
     * @return \App\Holder\Page[]
     */
    public function getPageHoldersByFilter(\App\Filter\Page $filter) {
        return $this->database->getPageHoldersByFilter($filter);
    }

    /**
     * @param \App\Filter\Page $filter
     * @return \App\Holder\Page
     */
    public function getPageHolderByFilter(\App\Filter\Page $filter) {
        return $this->database->getPageHolderByFilter($filter);
    }

    /**
     * @param int $id_page
     * @return \App\Model\Page[]
     */
    public function getRelatedPages($id_page) {
        $related = $this->page_related_database->getPageRelated($id_page);
        $pages_ids = array();
        foreach($related as $row){
            if($row->id_page_a !== $id_page) $pages_ids[] = $row->id_page_a;
            if($row->id_page_b !== $id_page) $pages_ids[] = $row->id_page_b;
        }

        $pages_ids = array_unique($pages_ids);

        $pages = array();
        foreach($pages_ids as $page_id){
            $pages[] = $this->get($page_id);
        }

        return $pages;
    }

}