<?php

/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 9. 2015
 * Time: 17:53
 */

namespace App\Filter;

use App\Base\Filter;

class Page extends Filter {

    const LANGUAGES = "languages";
    const EXCLUDE_ID_PAGE = "excludeidpage";
    const PRIORITY = "priority";
    const MAX_RESOLUTION_WIDTH = "maxresolutionwidth";
    const MAX_RESOLUTION_HEIGHT = "maxresolutionheight";
    const MIN_RESOLUTION_WIDTH = "minresolutionwidth";
    const MIN_RESOLUTION_HEIGHT = "minresolutionheight";
    const TEXT_MODE = "textmode";
    const IMAGE_MODE = "imagemode";
    const DEVICES = "devices";
    const ID_PAGE = "idpage";
    const REQUIRED_COLOR = "requiredcolor";
    const REQUIRED_TEXT_COLOR = "requiredtextcolor";
    const CATEGORIES = "categories";
    const EXCLUDE_ID_WIREFRAME = "excludeidwireframe";
    const WEBSITE_VISIBLE = "websitevisible";
    const PAGE_VISIBLE = "pagevisible";
    const WIREFRAME_VISIBLE = "wireframevisible";

    /**
     * @return \string[]
     */
    public function getLanguages() {
        return $this->get(self::LANGUAGES);
    }

    /**
     * @param \string[] $languages
     */
    public function setLanguages($languages) {
        $this->set(self::LANGUAGES, $languages);
    }

    /**
     * @return \int[]
     */
    public function getExcludeIdPage() {
        return $this->get(self::EXCLUDE_ID_PAGE);
    }

    /**
     * @param \int[] $exclude_id_page
     */
    public function setExcludeIdPage($exclude_id_page) {
        $this->set(self::EXCLUDE_ID_PAGE,$exclude_id_page);
    }

    /**
     * @return boolean
     */
    public function isPriority() {
        return $this->get(self::PRIORITY);
    }

    /**
     * @param boolean $priority
     */
    public function setPriority($priority) {
        $this->set(self::PRIORITY,$priority);
    }
    /**
     * @return int
     */
    public function getMaxResolutionWidth() {
        return $this->get(self::MAX_RESOLUTION_WIDTH);
    }

    /**
     * @param int $max_resolution_width
     */
    public function setMaxResolutionWidth($max_resolution_width) {
        $this->set(self::MAX_RESOLUTION_WIDTH, $max_resolution_width);
    }

    /**
     * @return int
     */
    public function getMaxResolutionHeight() {
        return $this->get(self::MAX_RESOLUTION_HEIGHT);
    }

    /**
     * @param int $max_resolution_height
     */
    public function setMaxResolutionHeight($max_resolution_height) {
        $this->set(self::MAX_RESOLUTION_HEIGHT, $max_resolution_height);
    }

    /**
     * @return int
     */
    public function getMinResolutionWidth() {
        return $this->get(self::MIN_RESOLUTION_WIDTH);
    }

    /**
     * @param int $min_resolution_width
     */
    public function setMinResolutionWidth($min_resolution_width) {
        $this->set(self::MIN_RESOLUTION_WIDTH,$min_resolution_width);
    }

    /**
     * @return int
     */
    public function getMinResolutionHeight() {
        return $this->get(self::MIN_RESOLUTION_HEIGHT);
    }

    /**
     * @param int $min_resolution_height
     */
    public function setMinResolutionHeight($min_resolution_height) {
        $this->set(self::MIN_RESOLUTION_HEIGHT,$min_resolution_height);
    }

    /**
     * @return string
     */
    public function getTextMode() {
        return $this->get(self::TEXT_MODE);
    }

    /**
     * @param string $text_mode
     */
    public function setTextMode($text_mode) {
        $this->set(self::TEXT_MODE,$text_mode);
    }

    /**
     * @return string
     */
    public function getImageMode() {
        return $this->get(self::IMAGE_MODE);
    }

    /**
     * @param string $image_mode
     */
    public function setImageMode($image_mode) {
        $this->set(self::IMAGE_MODE, $image_mode);
    }

    /**
     * @return string[]
     */
    public function getDevices() {
        return $this->get(self::DEVICES);
    }

    /**
     * @param string[] $devices
     */
    public function setDevices($devices) {
        $this->set(self::DEVICES,$devices);;
    }

    /**
     * @return int
     */
    public function getIdPage() {
        return $this->get(self::ID_PAGE);
    }

    /**
     * @param int $id_page
     */
    public function setIdPage($id_page) {
        $this->set(self::ID_PAGE, $id_page);
    }

    /**
     * @return bool
     */
    public function isRequiredColor() {
        return $this->get(self::REQUIRED_COLOR);
    }

    /**
     * @param bool $required_color
     */
    public function setRequiredColor($required_color) {
        $this->set(self::REQUIRED_COLOR, $required_color);
    }

    /**
     * @return bool
     */
    public function isRequiredTextColor() {
        return $this->get(self::REQUIRED_TEXT_COLOR);
    }

    /**
     * @param bool $required_text_color
     */
    public function setRequiredTextColor($required_text_color) {
        $this->set(self::REQUIRED_TEXT_COLOR, $required_text_color);
    }

    /**
     * @return int[]
     */
    public function getCategories() {
        return $this->get(self::CATEGORIES);
    }

    /**
     * @param int[] $categories
     */
    public function setCategories($categories) {
        $this->set(self::CATEGORIES, $categories);
    }

    /**
     * @return int[]
     */
    public function getExcludeIdWireframe() {
        return $this->get(self::EXCLUDE_ID_WIREFRAME);
    }

    /**
     * @param int[] $exclude_id_wireframe
     */
    public function setExcludeIdWireframe($exclude_id_wireframe) {
        $this->set(self::EXCLUDE_ID_WIREFRAME, $exclude_id_wireframe);
    }

    /**
     * @return bool
     */
    public function isWebsiteVisible() {
        if($this->get(self::WEBSITE_VISIBLE) === null){
            return true;
        }
        return $this->get(self::WEBSITE_VISIBLE);
    }

    /**
     * @param bool $visible
     */
    public function setWebsiteVisible($visible) {
        $this->set(self::WEBSITE_VISIBLE, $visible);
    }

    /**
     * @return bool
     */
    public function isPageVisible() {
        if($this->get(self::PAGE_VISIBLE) === null){
            return true;
        }
        return $this->get(self::PAGE_VISIBLE);
    }

    /**
     * @param bool $visible
     */
    public function setPageVisible($visible) {
        $this->set(self::PAGE_VISIBLE, $visible);
    }
    /**
     * @return bool
     */
    public function isWireframeVisible() {
        if($this->get(self::WIREFRAME_VISIBLE) === null){
            return true;
        }
        return $this->get(self::WIREFRAME_VISIBLE);
    }

    /**
     * @param bool $visible
     */
    public function setWireframeVisible($visible) {
        $this->set(self::WIREFRAME_VISIBLE, $visible);
    }

}