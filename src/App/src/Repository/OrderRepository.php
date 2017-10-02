<?php


namespace App\Repository;


use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\Reflection;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @var null|AdapterInterface
     */
    private $db = null;

    /**
     * @var null
     */
    private $dateTime = null;

    /**
     * OrderRepository constructor.
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->db = $adapter;
        $this->dateTime = new \DateTime();
    }

    /**
     * @param $object
     * @param string $tableName
     * @return mixed
     */
    public function prepare($object, string $tableName)
    {
        $insert = new Insert($tableName);
        $hydrate = new Reflection();
        $insert->values($hydrate->extract($object));
        return $this->insert($insert);
    }

    /**
     * Встаквка в связующую таблицу
     * @param array $data
     * @return mixed
     */
    public function setRelationTable(array $data)
    {
        $insert = new Insert('orders_product');
        $insert->values($data);
        return $this->insert($insert);
    }

    /**
     * @param $insert Insert
     * @return mixed
     */
    public function insert(Insert $insert)
    {
        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        if (! $result instanceof ResultInterface) {
            throw new \RuntimeException(sprintf('Failed retrieving unknown database error.'));
        }
        return $result->getGeneratedValue();
    }

    /**
     * Получение заказа по хеш
     * @param string $hash
     * @return mixed
     */
    public function getOrderByHash(string $hash)
    {
        $select = new Select();
        $select->from(['o' => 'orders']);
        $select->join('addresses', 'o.address_id = addresses.id', ['city', 'postal_code', 'address1', 'address2'], $select::JOIN_LEFT);
        $select->join('customers', 'o.customer_id = customers.id', ['name', 'email'], $select::JOIN_LEFT);
        $select->where(['hash = ?' => $hash]);
        $response = $this->setPrepareSql($select, true);
        $response['product'] = $this->getProductsByOrder($response['id']);
        return $response;
    }

    /**
     * @param int $id
     * @return array|\ArrayObject|null
     */
    public function getProductsByOrder(int $id)
    {
        $select = new Select();
        $select->from('orders_product');
        $select->join('products', 'orders_product.product_id = products.id', ['*'], $select::JOIN_LEFT);
        $select->where(['orders_product.order_id = ?' => $id]);
        return $this->setPrepareSql($select);
    }

    /**
     * @param Select $select
     * @param bool $single
     * @return array|\ArrayObject|null
     */
    public function setPrepareSql(Select $select, $single = false)
    {
        $sql = new Sql($this->db);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        if (! $result instanceof ResultInterface) {
            throw new \RuntimeException(sprintf('Failed retrieving unknown database error.'));
        }
        $resultSet = new ResultSet();
        $resultSet->initialize($result);
        if ($single === true) {
            return $resultSet->current();
        }
        return $resultSet->toArray();
    }
}