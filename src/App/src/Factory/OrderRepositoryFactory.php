<?php

namespace App\Factory;



use App\Repository\OrderRepository;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;

class OrderRepositoryFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new OrderRepository($container->get(AdapterInterface::class));
    }
}