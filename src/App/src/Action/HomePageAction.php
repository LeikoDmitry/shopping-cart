<?php

namespace App\Action;

use App\Repository\ProductsRepository;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

/**
 * Class HomePageAction
 * @package App\Action
 */
class HomePageAction implements ServerMiddlewareInterface
{
    /**
     * @var Router\RouterInterface
     */
    private $router;

    /**
     * @var Template\TemplateRendererInterface
     */
    private $template;

    /**
     * @var ProductsRepository
     */
    private $repository;

    /**
     * HomePageAction constructor.
     * @param Router\RouterInterface $router
     * @param Template\TemplateRendererInterface|null $template
     * @param ProductsRepository $repository
     */
    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null, ProductsRepository $repository)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->repository = $repository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return HtmlResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        return new HtmlResponse($this->template->render('app::home-page', ['products' => $this->repository->getProducts()]));
    }
}
