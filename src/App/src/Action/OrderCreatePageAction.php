<?php


namespace App\Action;


use App\Events\HandleEvent;
use App\Events\RemoveSession;
use App\Events\UpdateOrder;
use App\Events\UpdateOrderPaid;
use App\Events\WritePaymentTransaction;
use App\Filter\ValidatorApp;
use App\Model\Addresses;
use App\Model\Customers;
use App\Model\Orders;
use App\Model\Payment;
use App\Model\Product;
use App\Repository\CartRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductsRepository;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\InputFilter\Factory;


class OrderCreatePageAction implements MiddlewareInterface
{
    /**
     * @var null|AdapterInterface
     */
    private $adapter = null;

    /**
     * @var null
     */
    private $route   = null;

    /**
     * @var
     */
    private $orderRepository = null;

    /**
     * @var null
     */
    private $cartRepository = null;

    /**
     * @var null
     */
    private $productRepository = null;


    /**
     * OrderCreatePageAction constructor.
     * @param AdapterInterface $adapter
     * @param RouterInterface $router
     * @param OrderRepository $orderRepository
     * @param ProductsRepository $productsRepository
     * @param CartRepository $cartRepository
     */
    public function __construct(AdapterInterface $adapter, RouterInterface $router, OrderRepository $orderRepository, CartRepository $cartRepository, ProductsRepository $productsRepository)
    {
        $this->adapter         = $adapter;
        $this->route           = $router;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productsRepository;
        $this->cartRepository    = $cartRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return RedirectResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if ($request->getMethod() !== 'POST') {
            return new RedirectResponse($this->route->generateUri('cart'));
        }
        if (! isset($request->getParsedBody()['payment_method_nonce'])) {
            return new RedirectResponse($this->route->generateUri('order.index'));
        }
        $data = $request->getParsedBody();
        $validator = new ValidatorApp(new Factory(), $this->adapter);
        $validate = $validator->validate($data);
        if ($validator->getErrors() === null) {
            if (is_array($validate)) {
                $idCustommer = $this->orderRepository->prepare(new Customers($validate), 'customers');
                $idAddresses = $this->orderRepository->prepare(new Addresses($validate), 'addresses');
                $sessionStore = $this->cartRepository->all($this->productRepository);
                $hash = bin2hex(random_bytes(32));
                $orders = new Orders();
                $orders->setHash($hash);
                $orders->setCustomerId($idCustommer);
                $orders->setAddressId($idAddresses);
                $orders->setTotal($this->cartRepository->getTotal() + 5);
                $orders->setPaid(false);
                $orderId = $this->orderRepository->prepare($orders, 'orders');
                $response_branitree = \Braintree_Transaction::sale([
                    'amount' => $this->cartRepository->getTotal() + 5,
                    'orderId' => $orderId,
                    'paymentMethodNonce' => $request->getParsedBody()['payment_method_nonce'],
                    'options' => [
                        'submitForSettlement' => true,
                    ],
                ]);
                if ($response_branitree->success) {
                    $attach = new HandleEvent($this->cartRepository, $this->adapter);
                    foreach ($sessionStore as $item) {
                        if ($item instanceof Product) {
                            $this->orderRepository->setRelationTable([
                                'order_id'   => $orderId,
                                'product_id' => $item->getId(),
                                'quantity'   => $item->getQuantity(),
                            ]);
                            new RemoveSession($attach, $item);
                        }
                    }
                    new UpdateOrderPaid($attach, $this->adapter, $orderId);
                    $payment = new Payment();
                    $payment->setOrderId($orderId);
                    $payment->setFailed(true);
                    $payment->setTransactionId($response_branitree->transaction->id);
                    new WritePaymentTransaction($attach, $payment);
                    $attach->notify();
                }
                return new RedirectResponse($this->route->generateUri('show-order', ['hash' => $hash]));
            }
        }
        $flash = $request->getAttribute('flash');
        $flash->addMessage('errors', $validator->getErrors());
        $flash->addMessage('oldInput', $data);
        return new RedirectResponse($this->route->generateUri('order.index'));
    }
}