<?php

namespace App\Factory;


use App\Model\Product;
use App\Repository\CartRepository;
use App\Repository\ProductsRepository;
use Interop\Container\ContainerInterface;
use Zend\Session\Container;

/**
 * Class CartRepositoryFactory
 * @package App\Factory
 */
class CartRepositoryFactory
{
    /**
     * @param ContainerInterface $container
     * @return CartRepository
     */
    public function __invoke(ContainerInterface $container)
    {
        return new CartRepository();
    }
}