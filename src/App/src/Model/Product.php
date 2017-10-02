<?php

namespace App\Model;

use Zend\Hydrator\Reflection;
use Zend\Form\Annotation;

/**
 * Class Product
 * @Annotation\Name("user")
 * @Annotation\Hydrator("Zend\Hydrator\Reflection")
 * @package App\Model
 */
class Product
{
    /**
     * @Annotation\Exclude()
     * @var int
     */
    private $id;

    /**
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Название:"})
     * @var string
     */
    private $title;

    /**
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1}})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Attributes({"type":"Описание"})
     * @Annotation\Options({"label":"Название:"})
     * @var string
     */
    private $description;

    /**
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Slug:"})
     * @var string
     */
    private $slug;

    /**
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Цена:"})
     * @var float
     */
    private $price;

    /**
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Attributes({"type":"Изображение"})
     * @Annotation\Options({"label":"Название:"})
     * @var string
     */
    private $image;

    /**
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"В наличии:"})
     * @var int
     */
    private $stock;

    /**
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":255}})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Количество:"})
     * @var int
     */
    private $quantity = null;

    /**
     * Model constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (! empty($data)) {
            $hydrate = new Reflection();
            $hydrate->hydrate($data, $this);
        }
    }

    /**
     * @return mixed
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getSlug() : string
    {
        return $this->slug;
    }

    /**
     * @param $slug string
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getImage() : string
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage(string $image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getStock() : string
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock(int $stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
}