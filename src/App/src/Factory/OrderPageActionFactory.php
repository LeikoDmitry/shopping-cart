<?php


namespace App\Factory;


use App\Action\OrderPageAction;
use App\Repository\CartRepository;
use App\Repository\ProductsRepository;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class OrderPageActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new OrderPageAction(
            $container->get(RouterInterface::class),
            $container->get(TemplateRendererInterface::class),
            $container->get(CartRepository::class),
            $container->get(ProductsRepository::class)
        );
    }
}