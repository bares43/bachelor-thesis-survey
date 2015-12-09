<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 9. 12. 2015
 * Time: 19:54
 */

namespace App\Base;


class Presenter extends \Nette\Application\UI\Presenter{

    public function startup() {

        parent::startup();

        if(array_key_exists("google_analytics_code", $this->context->getParameters())){
            $this->template->google_analytics_code = $this->context->getParameters()["google_analytics_code"];
        }
    }
}