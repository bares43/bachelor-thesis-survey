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
    const USER_AGENT = "user_agent";

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
     * @return string
     */
    public function getUserAgent() {
        return $this->get(self::USER_AGENT);
    }

    /**
     * @param string $user_agent
     */
    public function setUserAgent($user_agent) {
        $this->set(self::USER_AGENT,$user_agent);;
    }


}