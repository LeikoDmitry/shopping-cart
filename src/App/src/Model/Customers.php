<?php

namespace App\Model;


use Zend\Db\Sql\Expression;
use Zend\Hydrator\Reflection;

class Customers
{
    /**
     * @var null | int
     */
    private $id = null;

    /**
     * @var null | string
     */
    private $name = null;

    /**
     * @var null | string
     */
    private $email = null;

    /**
     * @var null | string
     */
    private $created_at = null;

    /**
     * @var null | string
     */
    private $update_at  = null;

    public function __construct(array $post = [])
    {
        if (! empty($post)) {
            $hydrate = new Reflection();
            $hydrate->hydrate($post, $this);
        }
        $this->created_at = new Expression('NOW()');
        $this->update_at  = new Expression('NOW()');
    }

    /**
     * @return int|null
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param null|string $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return null|string
     */
    public function getUpdateAt()
    {
        return $this->update_at;
    }

    /**
     * @param null|string $update_at
     */
    public function setUpdateAt($update_at)
    {
        $this->update_at = $update_at;
    }
}