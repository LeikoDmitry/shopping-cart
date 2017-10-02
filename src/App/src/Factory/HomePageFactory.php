<?php

namespace App\Factory;

use App\Action\HomePageAction;
use App\Repository\ProductsRepository;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class HomePageFactory
 * @package App\Action
 */
class HomePageFactory
{
    /**
     * @param ContainerInterface $container
     * @return HomePageAction
     */
    public function __invoke(ContainerInterface $container)
    {
        $router   = $container->get(RouterInterface::class);
        $template =  $container->has(TemplateRendererInterface::class) ? $container->get(TemplateRendererInterface::class) : null;
        $repository = $container->get(ProductsRepository::class);

        return new HomePageAction($router, $template, $repository);
    }
}
