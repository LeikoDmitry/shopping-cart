<?php

namespace App\Repository;


use App\Model\Product;
use Zend\Session\Container;

class CartRepository implements CartRepositoryInterface
{
    /**
     * @var Container
     */
    private $manager;

    /**
     * @var int
     */
    private $total = null;

    /**
     * CartRepository constructor.
     * @param $default
     */
    public function __construct($default = 'basket')
    {
        $this->manager = new Container($default);
    }

    /**
     * Добавление
     * @param Product $product
     * @param $count
     */
    public function add(Product $product, $count)
    {
        if ($this->has($product)) {
            $count = $this->get($product)['quantity'] + $count;
        }
        $this->update($product, $count);
    }

    /**
     * Проверка
     * @param Product $product
     * @return mixed
     */
    public function has(Product $product)
    {
        return $this->manager->offsetExists($product->getId());
    }

    /**
     * Обновление
     * @param Product $product
     * @param $quantity
     */
    public function update(Product $product, $quantity)
    {
        $this->manager->offsetSet($product->getId(), [
            'product_id' => (int) $product->getId(),
            'quantity'   => $quantity,
        ]);
    }

    /**
     * Удаление
     * @param Product $product
     */
    public function remove(Product $product)
    {
        $this->manager->offsetUnset($product->getId());
    }

    /**
     * @param Product $product
     * @return mixed
     */
    public function get(Product $product)
    {
        return $this->manager->offsetGet($product->getId());
    }

    /**
     * Удаление сессии
     */
    public function clear()
    {
        $this->manager->getManager()->destroy();
    }

    /**
     * Получение всех продуктов из сессии
     * @param $repository
     * @return mixed
     */
    public function all(ProductsRepository $repository)
    {
        $ids = [];
        $items = [];
        $total = 0;
        if ($this->manager) {
            foreach ($this->manager as $item) {
                $ids[] = $item['product_id'];
            }
            if ($this->ItemCount()) {
                $products = $repository->getAllProductByIds($ids);
                foreach ($products as $product) {
                    if ($product instanceof Product) {
                        $product->setQuantity($this->get($product)['quantity']);
                        $items[] = $product;
                    }
                    $total = (float)$total + $product->getPrice() * $product->getQuantity();
                }
                $this->setTotal($total);
                return $items;
            }
        }
        return [];
    }

    /**
     * Получение количества элементов
     * @return int
     */
    public function ItemCount()
    {
        return count($this->manager->getArrayCopy());
    }

    /**
     * Установка полной стоимости продукта
     * @param float $total
     */
    public function setTotal(float $total)
    {
        $this->total = $total;
    }

    /**
     * Получение стоимости продукта
     * @return float
     */
    public function getTotal() : float
    {
        return $this->total;
    }

    /**
     * @param Product $product
     * @param $count_col
     */
    public function updateStore(Product $product, $count_col)
    {
        if ($this->has($product)) {
            $this->remove($product);
        }
        $this->update($product, $count_col);
    }
}