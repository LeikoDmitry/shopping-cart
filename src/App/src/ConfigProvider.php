<?php

namespace App;


/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [

            ],
            'factories'  => [
                Action\HomePageAction::class => Factory\HomePageFactory::class,
                Action\HomeProductAction::class => Factory\HomeProductFactory::class,
                Action\CartPageAction::class => Factory\CartPageActionFactory::class,
                Action\CartPageAddAction::class => Factory\CartPageAddActionFactory::class,
                Action\OrderPageAction::class => Factory\OrderPageActionFactory::class,
                Action\OrderCreatePageAction::class => Factory\OrderCreatePageFactory::class,
                Action\ShowOrderAction::class => Factory\ShowOrderActionFactory::class,

                Repository\CartRepository::class => Factory\CartRepositoryFactory::class,
                Repository\ProductsRepository::class => Factory\ProductsRepositoryFactory::class,
                Repository\OrderRepository::class => Factory\OrderRepositoryFactory::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
