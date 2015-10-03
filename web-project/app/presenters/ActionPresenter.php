<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 3. 10. 2015
 * Time: 15:54
 */

namespace App\Presenters;


use App\Service\Code;
use Nette\Application\UI\Presenter;

class ActionPresenter extends Presenter {

    /** @var Code @inject */
    public $code_service;

    public function actionDefault(){
        $url = $this->request->getParameter("code");

        $code = $this->code_service->getByUrl($url);
        if($code !== null){
            $this->getSession()->getSection("survey")->code = $code->code;
        }

        $this->redirect("Survey:");
        exit;
    }
}