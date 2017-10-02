<?php


namespace App\Action;

use App\Repository\CartRepository;
use App\Repository\ProductsRepository;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;


class CartPageAction implements ServerMiddlewareInterface
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
     * @var CartRepository
     */
    private $repository;

    /**
     * @var ProductsRepository
     */
    private $productRepository;

    /**
     * HomePageAction constructor.
     * @param Router\RouterInterface $router
     * @param Template\TemplateRendererInterface|null $template
     * @param CartRepository $repository
     * @param $productsRepository
     */
    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $template = null,
        CartRepository $repository,
        ProductsRepository $productsRepository
    )
    {
        $this->router   = $router;
        $this->template = $template;
        $this->repository = $repository;
        $this->productRepository = $productsRepository;

    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return HtmlResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $products_cart = $this->repository->all($this->productRepository);
        return new HtmlResponse($this->template->render('app::cart-page', [
            'products_cart' => $products_cart,
        ]));
    }
}