<?php


namespace App\Middleware;


use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Braintree_Configuration;

class BrainTreeMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId('8nd7d6w4q3pvgg82');
        Braintree_Configuration::publicKey('m732vxsm9vsppc6r');
        Braintree_Configuration::privateKey('90485c3e79f56da68fbfed966b1c880f');
        return $delegate->process($request);
    }
}