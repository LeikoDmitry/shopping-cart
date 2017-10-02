<?php


namespace App\Factory;


use App\Action\ShowOrderAction;
use App\Repository\OrderRepository;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ShowOrderActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ShowOrderAction(
            $container->get(RouterInterface::class),
            $container->get(TemplateRendererInterface::class),
            $container->get(OrderRepository::class)
        );
    }
}