<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 5. 11. 2015
 * Time: 14:54
 */

namespace App\Holder\Mapper;

use App\Base\IMapper;
use App\Base\Service;

class PageRelated implements IMapper {

    /**
     * @param $result
     * @return \App\Holder\PageRelated
     */
    public function populate($result) {
        $holder = new \App\Holder\PageRelated();

        if(isset($result["page_related_id_page_related"])){
            $holder->setPageRelated(Service::populateEntity($result, \App\Model\PageRelated::getClassName(), "page_related"));
        }

        $page_a = new \App\Holder\Page();
        if(isset($result["page_a_id_page"])){
            $page_a->setPage(Service::populateEntity($result, \App\Model\Page::getClassName(), "page_a"));
        }

        if(isset($result["website_a_id_website"])){
            $page_a->setWebsite(Service::populateEntity($result, \App\Model\Website::getClassName(), "website_a"));
        }

        if(isset($result["wireframe_a_id_wireframe"])){
            $page_a->setCurrentWireframe(Service::populateEntity($result, \App\Model\Wireframe::getClassName(), "wireframe_a"));
        }
        $holder->setPageA($page_a);

        $page_b = new \App\Holder\Page();
        if(isset($result["page_b_id_page"])){
            $page_b->setPage(Service::populateEntity($result, \App\Model\Page::getClassName(), "page_b"));
        }

        if(isset($result["website_b_id_website"])){
            $page_b->setWebsite(Service::populateEntity($result, \App\Model\Website::getClassName(), "website_b"));
        }

        if(isset($result["wireframe_b_id_wireframe"])){
            $page_b->setCurrentWireframe(Service::populateEntity($result, \App\Model\Wireframe::getClassName(), "wireframe_b"));
        }
        $holder->setPageB($page_b);

        return $holder;
    }
}