<?php

/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 9. 2015
 * Time: 18:05
 */
namespace App\Holder;

use App\Base\IHolder;
use App\Model\Website;
use App\Model\Wireframe;

class Page implements IHolder {

    /** @var \App\Model\Page $page */
    private $page;

    /** @var Website $website */
    private $website;

    /** @var Wireframe */
    private $current_wireframe;

    /**
     * @return \App\Model\Page
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * @param \App\Model\Page $page
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
     * @return Wireframe
     */
    public function getCurrentWireframe() {
        return $this->current_wireframe;
    }

    /**
     * @param Wireframe $current_wireframe
     */
    public function setCurrentWireframe($current_wireframe) {
        $this->current_wireframe = $current_wireframe;
    }

}