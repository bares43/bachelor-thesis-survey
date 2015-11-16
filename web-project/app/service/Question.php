<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 27. 9. 2015
 * Time: 17:29
 */

namespace App\Service;


use App\Base\Filter;
use App\Base\Service;
use App\Filter\PageRelated;
use App\Holder\NewQuestion;
use App\Model\EntityCategory;
use App\Service\Page;
use App\Service\Subquestion;
use App\Service\Website;

class Question extends Service {

    /** @var \App\Database\Question */
    private $database;

    /** @var Page */
    private $page_service;

    /** @var Subquestion */
    private $subquestion_service;

    /** @var EntityCategory */
    private $entity_category_service;

    /**
     * Question constructor.
     * @param \App\Database\Question $db_question
     * @param Page $page_service
     * @param EntityCategory $entity_category_service
     * @param \App\Service\Subquestion $subquestion_service
     */
    public function __construct(\App\Database\Question $db_question, Page $page_service, EntityCategory $entity_category_service, Subquestion $subquestion_service) {
        $this->database = $db_question;
        $this->page_service = $page_service;
        $this->entity_category_service = $entity_category_service;
        $this->subquestion_service = $subquestion_service;
    }

    /**
     * @param $id_question
     * @return \App\Model\Question|null
     */
    public function get($id_question) {
        return $this->database->get($id_question);
    }

    /**
     * @return \App\Model\Question[]
     */
    public function getAll() {
        return $this->database->getAll();
    }

    /**
     * @param \App\Model\Question $question
     */
    public function save($question) {
        $this->database->save($question);
    }

    /**
     * @param int $id_page
     * @param int|null $id_respondent
     * @return \App\Model\Question
     */
    public function create($id_page, $id_respondent = null) {
        return $this->database->create($id_page, $id_respondent);
    }

    /**
     * @param \App\Model\Respondent|null $respondent
     * @return NewQuestion|null
     */
    public function generateNewQuestion($respondent) {
        $new_question = new NewQuestion();

        $options_wireframes = array(
            \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME=>0,
            \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_SELECT=>0,
            \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE=>0
        );
        $options_colors = array(
            \App\Model\Subquestion::QUESTION_TYPE_COLOR=>0,
            \App\Model\Subquestion::QUESTION_TYPE_COLOR_SELECT=>0
        );
        $options = $options_wireframes + $options_colors;

        /** @var string $question_type */
        $question_type = null;

        /** @var \App\Model\Question $question */
        $question = null;

        /** @var \App\Holder\Page $page_holder */
        $page_holder = null;


        $wireframes_ids = array();

        if($respondent !== null){

            // nastaveni jazyka do filtru
            $languages = array(\App\Model\Website::LANGUAGE_CZECH);
            if($respondent->english) $languages[] = \App\Model\Website::LANGUAGE_ENGLISH;

            $entity_categories = $this->entity_category_service->getEntityCategoriesByIdRespondent($respondent->id_respondent);
            $categories = array();
            foreach($entity_categories as $entity_category){
                if($entity_category->period !== EntityCategory::PERIOD_NEVER) {
                    $categories[] = $entity_category->id_category;
                }
            }

            $devices = array();
            if($respondent->device_phone) $devices[] = \App\Model\Respondent::DEVICE_PHONE;
            if($respondent->device_computer) $devices[] = \App\Model\Respondent::DEVICE_COMPUTER;
            if($respondent->device_tablet) $devices[] = \App\Model\Respondent::DEVICE_TABLET;
            if(count($devices) > 0) $devices[] = '';

            /** @var \App\Holder\Subquestion[] $subquestions */
            $subquestions = $this->getSubquestionHoldersByIdRespondent($respondent->id_respondent);

            $new_question->setRespondentSubquestionsCount(count($subquestions)-1);

            $rand = rand(1,100);

            $pages_ids_part = array();

            /** Respondent už zodpověděl nějaké otázky */
            if(count($subquestions) > 0) {

                $pages_ids = array();
                foreach($subquestions as $holder){
                    $pages_ids[] = $holder->getPage()->id_page;
                    if($holder->getWireframe() !== null) $wireframes_ids[] = $holder->getWireframe()->id_wireframe;

                    /** Spočítám kolikrát byl který typ otázky použit a později budu upřednosťnovat málo používáné */
                    $options[$holder->getSubquestion()->question_type]++;
                    if(array_key_exists($holder->getSubquestion()->question_type, $options_wireframes)) $options_wireframes[$holder->getSubquestion()->question_type]++;
                    if(array_key_exists($holder->getSubquestion()->question_type, $options_colors)) $options_colors[$holder->getSubquestion()->question_type]++;
                }
                $pages_ids_part = array_slice($pages_ids,10);
                $pages_ids = array_unique($pages_ids);
                arsort($options);
                arsort($options_wireframes);
                arsort($options_colors);

                /** @var \App\Holder\Subquestion $last_subquestion */
                $last_subquestion = end($subquestions);

                /** Poslední page, pokud byla zodpovězena špatně, jen s jiným typem otázky */
                if ((($rand >= 1 && $rand <= 30) || ($rand >= 70 && $rand <= 90)) && $last_subquestion->getSubquestion()->correct !== null && !$last_subquestion->getSubquestion()->correct) {

                    $cnt = 3;
                    $page_holder = null;
                    while($page_holder === null && $cnt > 0){
                        --$cnt;
                        $filter = new \App\Filter\Page();
                        $filter->setIdPage($last_subquestion->getPage()->id_page);
                        $filter->setExcludeIdWireframe($wireframes_ids);

                        /** Byl zobrazen wireframe a page má nadefinované barvy - zobrazí se otázka na barvy */
                        if($cnt === 3 && in_array($last_subquestion->getSubquestion()->question_type,array_keys($options_wireframes))){
                            $question_type = array_rand($options_colors);
                            $filter->setRequiredColor(true);
                            $filter->setRequiredTextColor(true);
                        }
                        /** Byl zobrazen wireframe bez obrázku - zobrazí se wireframe kde jsou místo obrázků šedé boxy */
                        else if($cnt === 2 && in_array($last_subquestion->getSubquestion()->question_type,array_keys($options_wireframes)) && $last_subquestion->getWireframe()->image_mode === \App\Model\Wireframe::IMAGE_REMOVE){
                            $question_type = array_rand($options_wireframes);
                            $filter->setImageMode(\App\Model\Wireframe::IMAGE_BOX);
                        }
                        /** Byl zobrazen wireframe se šedými boxy - zobrazí se wireframe kde jsou rozmazené obrázky */
                        else if($cnt === 1 && in_array($last_subquestion->getSubquestion()->question_type,array_keys($options_wireframes)) && $last_subquestion->getWireframe()->image_mode === \App\Model\Wireframe::IMAGE_BOX){
                            $question_type = array_rand($options_wireframes);
                            $filter->setImageMode(\App\Model\Wireframe::IMAGE_BLUR);
                        }

                        $page_holder = $this->page_service->getPageHolderByFilter($filter);
                        if($page_holder !== null){
                            $question = $last_subquestion->getQuestion();
                        }
                    }
                }
                /** Page která již byla zobrazena s jiným typem otázky */
                else if ($rand >= 80 && $rand <= 100 && count($pages_ids_part) > 0) {
                    $filter = new \App\Filter\Page();
                    $page_id = $pages_ids_part[array_rand($pages_ids_part)];
                    $filter->setIdPage($page_id);

                    if(in_array($last_subquestion->getSubquestion()->question_type,array_keys($options_wireframes))){
                        $question_type = key($options_colors);
                        $filter->setRequiredColor(true);
                        $filter->setRequiredTextColor(true);
                    }else{
                        $question_type = key($options_wireframes);
                    }

                    $page_holder = $this->page_service->getPageHolderByFilter($filter);

                }
                /** Náhodná prioritní page, kromě již zobrazených, nerespektuji nastavneí responenta */
                else if($rand >= 21 && $rand <= 35){
                    $page_holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                        array(
                            \App\Filter\Page::PRIORITY=>true,
                            \App\Filter\Page::EXCLUDE_ID_PAGE=>$pages_ids
                        )
                    ));
                    $question_type = key($options_wireframes);
                }
            }

            /**
             * Respondent ještě nezodpověděl žádné otázky a nebo se dosud nepodařilo vybrat otázku
             * Zobrazit pouze prioritní pages, odfiltrovat X posledních pages, respektovat nastavení respondenta
             */
            if($page_holder === null){
                $page_holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                    array(
                        \App\Filter\Page::PRIORITY=>true,
                        \App\Filter\Page::EXCLUDE_ID_PAGE=>$pages_ids_part,
                        \App\Filter\Page::LANGUAGES=>$languages,
                        \App\Filter\Page::CATEGORIES=>$categories,
                        \App\Filter\Page::DEVICES=>$devices
                    )
                ));
                $question_type = array_rand($options_wireframes);
            }
        }

        /**
         * Ještě neznáme respondenta nebo se dosud nepodařilo vybrat otázku
         * Náhodná prioritní page s náhodným typem otázky, kromě otázek na barvy
         */
        if($page_holder === null){
            $page_holder = $this->page_service->getPageHolderByFilter(new \App\Filter\Page(
                array(
                    \App\Filter\Page::PRIORITY=>true,
                    \App\Filter\Page::EXCLUDE_ID_WIREFRAME=>$wireframes_ids
                )
            ));
            $question_type = array_rand($options_wireframes);
        }

        if($page_holder !== null){

            $subquestion = new \App\Model\Subquestion();

//            $related = $this->page_service->getRelatedPagesHolders($page_holder);
            $related_holder = $this->page_service->getRelatedPagesByFilter(new PageRelated(array(
                \App\Base\Filter::LIMIT=>1,
                \App\Filter\PageRelated::IDS_PAGE=>array($page_holder->getPage()->id_page),
                \App\Filter\Page::PAGE_VISIBLE=>true
            )));

            /**
             * Pokud by se stalo, že je vybraný typ otázky, který potřebuje podobné příbuzné stránky z výběru, a aktuální page je nemá
             */
            if(count($related_holder) === 1 && $related_holder[0] !== null){
                $new_question->setPageRelated($related_holder[0]);
                $subquestion->id_page_related = $related_holder[0]->getPageRelated()->id_page_related;
            }else{
                if($question_type === \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_REVERSE || $question_type === \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME_SELECT){
                    $question_type = \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME;
                }
                else if($question_type === \App\Model\Subquestion::QUESTION_TYPE_COLOR_SELECT){
                    $question_type = \App\Model\Subquestion::QUESTION_TYPE_COLOR;
                }
            }


            if($question === null){
                $question = new \App\Model\Question();
                if($respondent !== null) $question->id_respondent = $respondent->id_respondent;
                $question->id_page = $page_holder->getPage()->id_page;

                $this->save($question);
            }

            if($question_type === null) $question_type = \App\Model\Subquestion::QUESTION_TYPE_WIREFRAME;

            $subquestion->id_question = $question->id_question;
            $subquestion->question_type = $question_type;
            if($page_holder->getCurrentWireframe() !== null) $subquestion->id_wireframe = $page_holder->getCurrentWireframe()->id_wireframe;

            $this->subquestion_service->save($subquestion);

            $new_question->setQuestion($question);
            $new_question->setSubquestion($subquestion);
            $new_question->setPageHolder($page_holder);
            $new_question->setQuestionType($question_type);
//            $new_question->setPagesHolders($related);

            return $new_question;
        }else{
            return null;
        }
    }

    /**
     * @param int $id_respondent
     * @return \App\Holder\Subquestion[]
     */
    public function getSubquestionHoldersByIdRespondent($id_respondent) {
        return $this->database->getSubquestionHoldersByIdRespondent($id_respondent);
    }

    /**
     * @param int $id_respondent
     * @return \App\Holder\PageRelated[]
     */
    public function getDuelsPagesByIdRespondent($id_respondent) {
        $subquestions = $this->database->getSubquestionHoldersByIdRespondent($id_respondent);
        $ids_page_related = array();
        foreach($subquestions as $subquestion){
            if($subquestion->getSubquestion()->id_page_related !== null && !in_array($subquestion->getSubquestion()->id_page_related, $ids_page_related)){
                $ids_page_related[] = $subquestion->getSubquestion()->id_page_related;
            }
        }
        return $this->page_service->getRelatedPagesByFilter(new PageRelated(
            array(
                PageRelated::DUEL=>true,
                PageRelated::IDS_PAGE_RELATED=>$ids_page_related
            )
        ));
    }
}