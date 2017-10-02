<?php


namespace App\Events;


use SplSubject;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

class UpdateOrderPaid extends EventObserver
{
    /**
     * @var null
     */
    private $order_id = null;

    /**
     * @var null
     */
    private $adapter = null;

    /**
     * UpdateOrderPaid constructor.
     * @param SplSubject $splSubject
     * @param $order_id,
     * @param $adapter
     */
    public function __construct(SplSubject $splSubject, AdapterInterface $adapter, $order_id)
    {
        parent::__construct($splSubject);
        $this->order_id = $order_id;
        $this->adapter = $adapter;
    }

    /**
     * @param $subject
     * @return mixed|null
     */
    public function doUpdate($subject)
    {
        $update = new Update('orders');
        $update->set(['paid' => true]);
        $update->where(['id = ? ' => $this->order_id]);
        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();
        return $result->getGeneratedValue();
    }
}