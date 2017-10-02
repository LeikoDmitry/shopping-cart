<?php

namespace App\Model;


use Zend\Db\Sql\Expression;
use Zend\Hydrator\Reflection;

class Addresses
{
    /**
     * @var null
     */
    private $id = null;

    /**
     * @var null
     */
    private $address1 = null;

    /**
     * @var null
     */
    private $address2 = null;

    /**
     * @var null
     */
    private $city = null;

    /**
     * @var null
     */
    private $postal_code = null;

    /**
     * @var null
     */
    private $create_at = null;

    /**
     * @var null
     */
    private $update_at = null;

    /**
     * Addresses constructor.
     * @param array $post
     */
    public function __construct(array $post = [])
    {
        if (! empty($post)) {
            $hydrate = new Reflection();
            $hydrate->hydrate($post, $this);
        }
        $this->create_at = new Expression('NOW()');
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
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param null $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * @return null
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param null $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param null $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return null
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param null $postal_code
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return null
     */
    public function getCreateAt()
    {
        return $this->create_at;
    }

    /**
     * @param null $create_at
     */
    public function setCreateAt($create_at)
    {
        $this->create_at = $create_at;
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