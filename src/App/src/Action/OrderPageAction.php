<?php


namespace App\Action;


use App\Repository\ProductsRepository;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Repository\CartRepository;

class OrderPageAction implements MiddlewareInterface
{
    /**
     * @var null|Router\Route
     */
    private $route = null;
    private $template = null;
    private $cartRepository = null;
    private $productRepository;

    /**
     * OrderPageAction constructor.
     * @param Router\RouterInterface $route
     * @param TemplateRendererInterface $templateRenderer
     * @param CartRepository $cartRepository
     * @param ProductsRepository $productsRepository
     */
    public function __construct(
        Router\RouterInterface $route,
        TemplateRendererInterface $templateRenderer,
        CartRepository $cartRepository,
        ProductsRepository $productsRepository
    )
    {
        $this->route = $route;
        $this->template = $templateRenderer;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productsRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return HtmlResponse|RedirectResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if (! $this->cartRepository->ItemCount()) {
            return new RedirectResponse($this->route->generateUri('home'));
        }
        $products_cart = $this->cartRepository->all($this->productRepository);
        $flash = $request->getAttribute('flash');
        $messages = $flash->getMessages();
        $errors   = isset($messages['errors'])   ? $messages['errors'][0]   : [];
        $oldInput = isset($messages['oldInput']) ? $messages['oldInput'][0] : [];
        return new HtmlResponse($this->template->render('app::order-page', [
            'product_cart' => $products_cart,
            'errors'       => $errors,
            'oldInput'     => $oldInput,
        ]));
    }
}