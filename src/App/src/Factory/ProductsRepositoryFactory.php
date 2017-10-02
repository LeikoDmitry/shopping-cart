<?php

namespace App\Factory;


use App\Repository\ProductsRepository;
use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;

/**
 * Class ProductsRepositoryFactory
 * @package App\Factory
 */
class ProductsRepositoryFactory
{
    /**
     * @param ContainerInterface $container
     * @return ProductsRepository
     */
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get(AdapterInterface::class);
        return new ProductsRepository($adapter);
    }
}