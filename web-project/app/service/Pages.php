<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 17:06
 */
namespace App\Service;

use Kdyby\Doctrine\EntityManager;
use Nette;
use App\Model;
use Kdyby\Doctrine;

class Pages extends BaseService {

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Model\Page::class);
    }

    /**
     * @return Model\Page[]
     */
    public function getAll()
    {
        return $this->_getAll();
    }

    /**
     * @param int $id
     * @return Model\Page|null
     */
    public function get($id)
    {
        return $this->_get($id);
    }

    /**
     * @param Model\Page $page
     */
    public function save(Model\Page $page)
    {
        $this->_save($page);
    }
}