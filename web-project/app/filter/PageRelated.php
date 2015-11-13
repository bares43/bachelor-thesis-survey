<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 5. 11. 2015
 * Time: 13:08
 */

namespace App\Filter;

class PageRelated extends Page {

    const DUEL = "duel";
    const IDS_PAGE = "idspage";
    const IDS_PAGE_RELATED = "idspagerelated";

    /**
     * @param bool $duel
     */
    public function setDuel($duel) {
        $this->set(self::DUEL, $duel);
    }

    /**
     * @return bool
     */
    public function isDuel() {
        return $this->get(self::DUEL);
    }

    /**
     * @param int[] $ids_page
     */
    public function setIdsPage($ids_page) {
        $this->set(self::IDS_PAGE, $ids_page);
    }

    /**
     * @return int[]
     */
    public function getIdsPage() {
        return $this->get(self::IDS_PAGE);
    }

    /**
     * @param int[] $ids_page_related
     */
    public function setIdsPageRelated($ids_page_related) {
        $this->set(self::IDS_PAGE_RELATED, $ids_page_related);
    }

    /**
     * @return int[]
     */
    public function getIdsPageRelated() {
        return $this->get(self::IDS_PAGE_RELATED);
    }
}