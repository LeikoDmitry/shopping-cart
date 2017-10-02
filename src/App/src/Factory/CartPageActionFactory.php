<?php
namespace App\Factory;

use App\Action\CartPageAction;
use App\Repository\CartRepository;
use App\Repository\ProductsRepository;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CartPageActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $router = $container->get(RouterInterface::class);
        $template = $container->get(TemplateRendererInterface::class);
        $repository = $container->get(CartRepository::class);
        return new CartPageAction($router, $template, $repository, $container->get(ProductsRepository::class));
    }
}