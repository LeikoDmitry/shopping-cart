<?php

namespace App\Model;


use Zend\Db\Sql\Expression;
use Zend\Hydrator\Reflection;

class Payment
{
    private $id = null;
    private $order_id = null;
    private $failed = null;
    private $transaction_id = null;
    private $created_at = null;
    private $update_at = null;

    public function __construct(array $post = [])
    {
        if (! empty($post)) {
            $hydrate = new Reflection();
            $hydrate->hydrate($post, $this);
        }
        $this->created_at = new Expression('NOW()');
        $this->update_at = new Expression('NOW()');
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param null $order_id
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * @return null
     */
    public function getFailed()
    {
        return $this->failed;
    }

    /**
     * @param null $failed
     */
    public function setFailed($failed)
    {
        $this->failed = $failed;
    }

    /**
     * @return null
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * @param null $transaction_id
     */
    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    /**
     * @return null
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param null $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return null
     */
    public function getUpdateAt()
    {
        return $this->update_at;
    }

    /**
     * @param null $update_at
     */
    public function setUpdateAt($update_at)
    {
        $this->update_at = $update_at;
    }
}