<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:29
 */

namespace App\Service;


use App\Base\Service;
use Nette\Utils\ArrayHash;

class Subquestion extends Service {

    /** @var \App\Database\Subquestion */
    private $database;

    /** @var Wireframe */
    private $wireframe_service;

    /**
     * Subquestion constructor.
     * @param \App\Database\Subquestion $db_subquestion
     * @param Wireframe $wireframe_service
     */
    public function __construct(\App\Database\Subquestion $db_subquestion, Wireframe $wireframe_service) {
        $this->database = $db_subquestion;
        $this->wireframe_service = $wireframe_service;
    }

    /**
     * @param $id_subquestion
     * @return \App\Model\Subquestion|null
     */
    public function get($id_subquestion) {
        return $this->database->get($id_subquestion);
    }

    /**
     * @return \App\Model\Subquestion[]
     */
    public function getAll() {
        return $this->database->getAll();
    }

    /**
     * @param \App\Model\Subquestion $subquestion
     */
    public function save($subquestion) {
        $this->database->save($subquestion);
    }

    /**
     * @param ArrayHash $values
     * @return \App\Model\Subquestion
     */
    public function saveBaseProperties($values){
        $subquestion = $this->get($values->id_subquestion);
        $subquestion->reason = $values->reason;
        $subquestion->seconds = $values->seconds;

        return $subquestion;
    }

    /**
     * @param int $question_type
     * @return string
     */
    public function questionTypeToString($question_type) {
        $question_type_string = "";
        switch($question_type){
            case \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME:
                $question_type_string = "wireframe";
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_SELECT:
                $question_type_string = "wireframeselect";
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE:
                $question_type_string = "wireframereverse";
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_COLOR:
                $question_type_string = "color";
                break;
            case \App\Model\Subquestion::QUESTION_TYPE_COLOR_SELECT:
                $question_type_string = "colorselect";
                break;
        }
        return $question_type_string;
    }

}