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
     * @param int[] $id_pages
     * @return \App\Holder\Page
     */
    public function getPageHolders($id_pages) {
        return $this->database->getPageHolders($id_pages);
    }

    /**
     * @param \App\Filter\Page $filter
     * @return \App\Holder\Page
     */
    public function getPageHolderByFilter(\App\Filter\Page $filter) {
        return $this->database->getPageHolderByFilter($filter);
    }

    /**
     * @param \App\Filter\PageRelated $filter
     * @return \App\Holder\PageRelated[]
     */
    public function getRelatedPagesByFilter(\App\Filter\PageRelated $filter) {
        return $this->page_related_database->getRelatedPagesByFilter($filter);
    }

    /**
     * @param \App\Filter\Results\Pages $filter
     * @return \App\Holder\Results\Base\Page
     */
    public function getResultsPages($filter = null) {
        return $this->database->getResultsPages($filter);
    }

    /**
     * @return \App\Holder\Page
     */
    public function getBasePageHolders() {
        return $this->database->getBasePageHolders();
    }
}