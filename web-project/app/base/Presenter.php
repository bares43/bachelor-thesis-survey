<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 9. 12. 2015
 * Time: 19:54
 */

namespace App\Base;


use App\Utils\Base;
use App\Utils\Respondent;

class Presenter extends \Nette\Application\UI\Presenter{

    public function startup() {

        parent::startup();

        if(array_key_exists("google_analytics_code", $this->context->getParameters())){
            $this->template->google_analytics_code = $this->context->getParameters()["google_analytics_code"];
        }

        if($this->getUser()->isLoggedIn()){
            $this->template->show_logout = true;
        }
    }

    protected function beforeRender()
    {
        $this->template->addFilter('time', function ($seconds) {
            return Base::getSecondsToString($seconds);
        });

        $this->template->addFilter('bool2string', function ($bool) {
            return Base::getBooleanToString($bool);
        });

        $this->template->addFilter('respondentWebsitePeriod', function($period){
            return Respondent::getRespondentWebsitePeriodLabel($period);
        });

        $this->template->addFilter('respondentAgeLabel', function($age){
            return Respondent::getAgeLabel($age);
        });

        $this->template->addFilter('respondentGenderLabel', function($gender){
            return Respondent::getGenderLabel($gender);
        });
    }
}