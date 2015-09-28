<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 9. 2015
 * Time: 18:13
 */

namespace App\Holder\Mapper;


use App\Base\IMapper;
use App\Base\Service;
use App\Model\Website;
use App\Model\Wireframe;

class Page implements IMapper {

    /**
     * @param $result
     * @return \App\Holder\Page
     */
    public function populate($result) {
        $holder = new \App\Holder\Page();

        if(isset($result["page_id_page"])){
            $holder->setPage(Service::populateEntity($result, \App\Model\Page::getClassName(), "page"));
        }

        if(isset($result["website_id_website"])){
            $holder->setWebsite(Service::populateEntity($result, Website::getClassName(), "website"));
        }

        if(isset($result["wireframe_id_wireframe"])){
            $holder->setWireframe(Service::populateEntity($result, Wireframe::getClassName(), "wireframe"));
        }

        return $holder;
    }
}