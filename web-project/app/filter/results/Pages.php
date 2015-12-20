<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 19. 12. 2015
 * Time: 17:02
 */

namespace App\Filter\Results;


use App\Base\Filter;

class Pages extends Filter{

    const IDS_PAGES = "idspages";

    /**
     * @param int[] $ids_pages
     */
    public function setIdsPages($ids_pages) {
        $this->set(self::IDS_PAGES, $ids_pages);
    }

    /**
     * @return int[]
     */
    public function getIdsPages() {
        return $this->get(self::IDS_PAGES);
    }
}