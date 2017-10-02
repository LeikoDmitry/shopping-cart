<?php

namespace App\Repository;


use App\Model\Product;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Hydrator\Reflection as ReflectionHydrator;
use Zend\Db\ResultSet\HydratingResultSet;

/**
 * Class ProductsRepository
 * @package App\Repository
 */
class ProductsRepository implements ProductsRepositoryInterface
{
    /**
     * @var null|AdapterInterface
     */
    private $adapter = null;

    /**
     * ProductsRepository constructor.
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Получение всех продуктов
     */
    public function getProducts()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select('products');
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $this->generateRequestObject($result);
    }

    /**
     * Получение продукта по его id
     * @param  $slug
     * @return object
     */
    public function getProductById(string $slug)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select('products');
        $select->where(['slug = ?' => $slug]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $product = $this->generateRequestObject($result, true);
        if (! $product) {
            return null;
        }
        return $product;
    }

    /**
     * Получение всех продуктов по массиву индификаторов
     * @param $ids
     * @return array|HydratingResultSet
     */
    public function getAllProductByIds($ids)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select('products');
        $select->where->in('id', $ids);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $this->generateRequestObject($result);
    }

    /**
     * Возрат запроса в нужную модель
     * @param $result
     * @param null $first
     * @return array|\ArrayObject|null|HydratingResultSet
     */
    protected function generateRequestObject($result, $first = null)
    {
        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new \RuntimeException(sprintf('Failed retrieving unknown database error.'));
        }
        $resultSet = new HydratingResultSet(new ReflectionHydrator(), new Product());
        if ($first !== null) {
            return $resultSet->initialize($result)->current();
        }
        $resultSet->initialize($result);
        return $resultSet;
    }

    /**
     * Обновление данных продукта
     * @param Product $product
     * @return mixed
     */
    public function update(Product $product)
    {
        if (! $product->getId()) {
            throw new \RuntimeException('Cannot update');
        }
        $hydrator = new ReflectionHydrator();
        $data = $hydrator->extract($product);
        $update = new Update('products');
        $update->set($data);
        $update->where(['slug' => (string) $product->getSlug()]);
        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();
        return $this->generateRequestObject($result, true);
    }
}