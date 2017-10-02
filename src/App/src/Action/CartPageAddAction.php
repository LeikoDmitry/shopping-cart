<?php


namespace App\Action;


use App\Model\Product;
use App\Repository\CartRepository;
use App\Repository\ProductsRepository;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Form\Annotation\AnnotationBuilder;

class CartPageAddAction implements ServerMiddlewareInterface
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
     * CartPageAddAction constructor.
     * @param Router\RouterInterface $router
     * @param Template\TemplateRendererInterface $templateRenderer
     * @param CartRepository $cartRepository
     * @param $productsRepository
     */
    public function __construct(
        Router\RouterInterface $router,
        Template\TemplateRendererInterface $templateRenderer,
        CartRepository $cartRepository,
        ProductsRepository $productsRepository
    )
    {
        $this->router = $router;
        $this->template = $templateRenderer;
        $this->repository = $cartRepository;
        $this->productRepository = $productsRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return RedirectResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $slug       = $request->getAttribute('slug');
        $quantity   = (int) $request->getAttribute('quantity');
        $product = $this->productRepository->getProductById($slug);
        if ($request->getMethod() !== 'POST') {
            if (! $product) {
                return new RedirectResponse($this->router->generateUri('home'));
            }
            if (! $product instanceof Product) {
                return new RedirectResponse($this->router->generateUri('home'));
            }
            $this->repository->add($product, $quantity);
            return new RedirectResponse($this->router->generateUri('cart'));
        }
        if ($product instanceof Product) {
            $form_builder = new AnnotationBuilder();
            $form = $form_builder->createForm(Product::class);
            $form->setData($request->getParsedBody());
            $form->setValidationGroup(['quantity']);
            if ($form->isValid()) {
                $this->repository->remove($product);
                $this->repository->add($product, (int)$form->getData()['quantity']);
            }
            return new RedirectResponse($this->router->generateUri('cart'));
        }
    }
}