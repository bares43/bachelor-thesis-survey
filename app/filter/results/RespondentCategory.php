<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 18. 12. 2015
 * Time: 16:10
 */

namespace App\Filter\Results;


use App\Base\Filter;

class RespondentCategory extends Filter{

    const ID_RESPONDENT = "idrespondent";

    /**
     * @param int $id_respondent
     */
    public function setIdRespondent($id_respondent) {
        $this->set(self::ID_RESPONDENT, $id_respondent);
    }

    /**
     * @return int
     */
    public function getIdRespondent() {
        return $this->get(self::ID_RESPONDENT);
    }
}