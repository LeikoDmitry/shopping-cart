<?php

namespace App\Model;


use Zend\Db\Sql\Expression;
use Zend\Hydrator\Reflection;

class Orders
{
    /**
     * @var null
     */
    private $id = null;

    /**
     * @var null
     */
    private $hash = null;

    /**
     * @var null
     */
    private $total = null;

    /**
     * @var null
     */
    private $address_id = null;

    /**
     * @var null
     */
    private $paid = null;

    /**
     * @var null
     */
    private $customer_id = null;

    /**
     * @var null
     */
    private $created_ad = null;

    /**
     * @var null
     */
    private $update_at = null;

    /**
     * Orders constructor.
     * @param array $post
     */
    public function __construct(array $post = [])
    {
        if (! empty($post)) {
            $hydrate = new Reflection();
            $hydrate->hydrate($post, $this);
        }
        $this->created_ad = new Expression('NOW()');
        $this->update_at  = new Expression('NOW()');
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
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param null $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return null
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param null $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->address_id;
    }

    /**
     * @param mixed $address_id
     */
    public function setAddressId($address_id)
    {
        $this->address_id = $address_id;
    }

    /**
     * @return null
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @param null $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * @return null
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param null $customer_id
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return null
     */
    public function getCreated()
    {
        return $this->created_ad;
    }

    /**
     * @param null $created_id
     */
    public function setCreated($created_id)
    {
        $this->created_ad = $created_id;
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