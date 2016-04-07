<?php

/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 3. 10. 2015
 * Time: 17:30
 */
namespace App\Holder;

use App\Base\IHolder;

class Category implements IHolder {
    /** @var \App\Model\Category */
    private $category;

    /** @var \App\Model\Category[] */
    private $children;

    /**
     * @return \App\Model\Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * @param \App\Model\Category $category
     */
    public function setCategory($category) {
        $this->category = $category;
    }

    /**
     * @return \App\Model\Category[]
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @param \App\Model\Category[] $children
     */
    public function setChildren($children) {
        $this->children = $children;
    }
}