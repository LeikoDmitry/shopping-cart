<?php


namespace App\Action;


use App\Repository\OrderRepository;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ShowOrderAction implements MiddlewareInterface
{
    /**
     * @var null
     */
    private $route = null;

    /**
     * @var null
     */
    private $template = null;

    /**
     * @var
     */
    private $orderRepository;

    /**
     * ShowOrderAction constructor.
     * @param RouterInterface $route
     * @param TemplateRendererInterface $templateRenderer
     * @param OrderRepository $orderRepository
     */
    public function __construct(RouterInterface $route, TemplateRendererInterface $templateRenderer, OrderRepository $orderRepository)
    {
        $this->route = $route;
        $this->template = $templateRenderer;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return HtmlResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $hash = $request->getAttribute('hash');
        $order = $this->orderRepository->getOrderByHash($hash);
        return new HtmlResponse($this->template->render('app::show-order', ['order' => $order]));
    }
}