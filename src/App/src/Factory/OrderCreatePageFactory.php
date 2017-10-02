<?php

namespace App\Factory;


use App\Action\OrderCreatePageAction;
use App\Repository\CartRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderRepositoryInterface;
use App\Repository\ProductsRepository;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Expressive\Router\RouterInterface;

class OrderCreatePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new OrderCreatePageAction(
            $container->get(AdapterInterface::class),
            $container->get(RouterInterface::class),
            $container->get(OrderRepository::class),
            $container->get(CartRepository::class),
            $container->get(ProductsRepository::class)
        );
    }
}