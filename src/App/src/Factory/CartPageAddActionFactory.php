<?php


namespace App\Factory;


use App\Action\CartPageAddAction;
use App\Repository\CartRepository;
use App\Repository\ProductsRepository;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class CartPageAddActionFactory
 * @package App\Action
 */
class CartPageAddActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return CartPageAddAction
     */
    public function __invoke(ContainerInterface $container)
    {
        return new CartPageAddAction(
            $container->get(RouterInterface::class),
            $container->get(TemplateRendererInterface::class),
            $container->get(CartRepository::class),
            $container->get(ProductsRepository::class)
        );
    }
}