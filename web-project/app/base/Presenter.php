<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 9. 12. 2015
 * Time: 19:54
 */

namespace App\Base;


use App\Model\RespondentWebsite;

class Presenter extends \Nette\Application\UI\Presenter{

    public function startup() {

        parent::startup();

        if(array_key_exists("google_analytics_code", $this->context->getParameters())){
            $this->template->google_analytics_code = $this->context->getParameters()["google_analytics_code"];
        }
    }

    protected function beforeRender()
    {
        $this->template->addFilter('time', function ($seconds) {
            $seconds = round($seconds);
            $hours = floor($seconds/3600);
            $seconds -= $hours*3600;
            $minutes = floor($seconds/60);
            $seconds -= $minutes*60;

            $res = "";
            $res .= $hours > 0 ? $hours."H " : "";
            $res .= $minutes > 0 ? $minutes."M " : "";
            $res .= $seconds."S";

            return $res;
        });

        $this->template->addFilter('respondentWebsitePeriod', function($period){
            switch($period){
                case RespondentWebsite::PERIOD_DONT_KNOW: return "neznám";
                case RespondentWebsite::PERIOD_KNOW_AND_VISIT: return "znám a navštěvuji";
                case RespondentWebsite::PERIOD_KNOW_THAT_EXISTS: return "vím, že existuje";
                default: return "";
            }
        });
    }
}