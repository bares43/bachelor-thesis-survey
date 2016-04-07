<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 18. 12. 2015
 * Time: 17:19
 */

namespace App\Base;


use App\Utils\Base;
use App\Utils\Respondent;
use Nette\Application\UI\Control;

class Component extends Control{

    protected function createTemplate($class = NULL)
    {
        $template = parent::createTemplate($class);

        $template->addFilter('time', function ($seconds) {
            return Base::getSecondsToString($seconds);
        });

        $template->addFilter('bool2string', function ($bool) {
            return Base::getBooleanToString($bool);
        });

        $template->addFilter('respondentWebsitePeriod', function($period){
            return Respondent::getRespondentWebsitePeriodLabel($period);
        });

        $template->addFilter('respondentAgeLabel', function($age){
            return Respondent::getAgeLabel($age);
        });

        $template->addFilter('respondentGenderLabel', function($gender){
            return Respondent::getGenderLabel($gender);
        });

        $template->addFilter('respondentCategoryPeriodLabel', function($period){
            return Respondent::getRespondentCategoryPeriodLabel($period);
        });

        return $template;
    }
}