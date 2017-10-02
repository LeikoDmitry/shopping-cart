<?php

namespace App\Factory;


use App\Action\HomeProductAction;
use App\Repository\ProductsRepository;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomeProductFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $router   = $container->get(RouterInterface::class);
        $template =  $container->has(TemplateRendererInterface::class) ? $container->get(TemplateRendererInterface::class) : null;
        $repository = $container->get(ProductsRepository::class);
        return new HomeProductAction($router, $template, $repository);
    }
}