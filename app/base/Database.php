<?php
/**
 * Created by PhpStorm.
 * User: janba_000
 * Date: 25. 8. 2015
 * Time: 16:51
 */

namespace App\Base;

use App\Utils\Arr;
use Doctrine\ORM\AbstractQuery;
use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\QueryBuilder;
use Nette;

class Database extends Nette\Object {

    /** @var EntityManager $entityManager */
    protected $entityManager;

    /** @var  string $repositoryName */
    protected $repositoryName;

    /**
     * @param EntityManager $entityManager
     * @param string $repositoryName
     */
    public function __construct(EntityManager $entityManager, $repositoryName)
    {
        $entityManager->getConfiguration()->addCustomNumericFunction("greatest",'App\Doctrine\Greatest');
        $entityManager->getConfiguration()->addCustomNumericFunction("least",'App\Doctrine\Least');
        $entityManager->getConfiguration()->addCustomNumericFunction("rand",'App\Doctrine\Rand');
        $entityManager->getConfiguration()->addCustomNumericFunction("countif",'App\Doctrine\CountIf');
        $entityManager->getConfiguration()->addCustomNumericFunction("round",'App\Doctrine\Round');
        $entityManager->getConfiguration()->addCustomNumericFunction("date",'App\Doctrine\Date');
        $this->entityManager = $entityManager;
        $this->repositoryName = $repositoryName;
    }
    /**
     * @return BaseEntity[]
     */
    protected function _getAll()
    {
        return $this->entityManager->getRepository($this->repositoryName)->findAll();
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return \Kdyby\Doctrine\Entities\BaseEntity[]
     */
    protected function _getBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->entityManager->getRepository($this->repositoryName)->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param int $id
     * @return null|BaseEntity
     */
    protected function _get($id)
    {
        return $this->entityManager->getRepository($this->repositoryName)->find($id);
    }

    /**
     * @param BaseEntity $entity
     */
    protected function _save(BaseEntity $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param QueryBuilder $query
     * @param IMapper $mapper
     * @return IMapper[]
     */
    protected function populateMapper($query, $mapper){
        $rows = $query->getQuery()->getResult(AbstractQuery::HYDRATE_SCALAR);
        $result = array();
        foreach($rows as $row){
            $result[] = $mapper->populate($row);
        }
        return $result;
    }

    /**
     * @param QueryBuilder $query
     * @param IMapper $mapper
     * @return IHolder
     */
    public function getHolder($query, $mapper) {
        $holders = $this->getHolders($query, $mapper);
        if(count($holders) === 1){
            return $holders[0];
        }else{
            return null;
        }
    }

    /**
     * @param QueryBuilder $query
     * @param IMapper $mapper
     * @return IHolder[]
     */
    public function getHolders($query, $mapper) {
        return $this->populateMapper($query, $mapper);
    }

    /**
     * @param array $filter_arr
     * @param QueryBuilder $query
     * @param string $column
     * @param boolean $having
     */
    public function createNumberCondition($filter_arr, $query, $column, $having = false) {
        if(is_array($filter_arr) && count($filter_arr) > 0){
            $expressions = array();
            if(Arr::is_assoc($filter_arr)){
                foreach($filter_arr as $operator => $value){
                    switch($operator){
                        case ">":
                            $expressions[] = $query->expr()->gt($column,$value); break;
                        case ">=":
                            $expressions[] = $query->expr()->gte($column,$value); break;
                        case "<":
                            $expressions[] = $query->expr()->lt($column,$value); break;
                        case "<=":
                            $expressions[] = $query->expr()->lte($column,$value); break;
                        case "=":
                            $expressions[] = $query->expr()->eq($column,$value); break;
                    }
                }
            }else{
                if(in_array(null,$filter_arr,true)){
                    $expressions[] = $query->expr()->orX(
                        $query->expr()->isNull($column),
                        $query->expr()->in($column,$filter_arr)
                    );
                }else{
                    $expressions[] = $query->expr()->in($column,$filter_arr);
                }
            }

            foreach($expressions as $expr){
                if($having){
                    $query->andHaving($expr);
                }else{
                    $query->andWhere($expr);
                }
            }
        }
    }


    /**
     * @param string $filter_str
     * @param QueryBuilder $query
     * @param string $column
     */
    public function createStringCondition($filter_str, $query, $column) {
        if ($filter_str !== null) {
            if (preg_match('/^%.+%$/', $filter_str)) {
                $query->andWhere($query->expr()->like($column, "'" . $filter_str . "'"));
            } else {
                $query->andWhere($query->expr()->eq($column, "'" . $filter_str . "'"));
            }
        }
    }

    /**
     * @param array $order_arr
     * @param QueryBuilder $query
     */
    public function createOrders($order_arr, $query) {
        foreach($order_arr as $by => $dir){
            $query->addOrderBy($by, $dir);
        }
    }
}