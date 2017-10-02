<?php

namespace App\Action;

use App\Repository\ProductsRepository;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

/**
 * Class HomeProductAction
 * @package App\Action
 */
class HomeProductAction implements ServerMiddlewareInterface
{
    /**
     * @var null|Template\TemplateRendererInterface
     */
    private $template = null;

    /**
     * @var ProductsRepository|null
     */
    private $repository = null;

    /**
     * @var null|Router\RouterInterface
     */
    private $route = null;

    /**
     * HomeProductAction constructor.
     * @param Router\RouterInterface $router
     * @param Template\TemplateRendererInterface $templateRenderer
     * @param ProductsRepository $repository
     */
    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $templateRenderer, ProductsRepository $repository)
    {
        $this->template = $templateRenderer;
        $this->repository = $repository;
        $this->route = $router;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return HtmlResponse|RedirectResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $slug = $request->getAttribute('slug');
        $product = $this->repository->getProductById($slug);
        if (! $product) {
            return new RedirectResponse($this->route->generateUri('home'));
        }
        return new HtmlResponse($this->template->render('app::product-page', ['product' => $product]));
    }
}