<?php

namespace App\Events;


use App\Model\Product;
use App\Repository\CartRepository;
use SplSubject;

class RemoveSession extends EventObserver
{
    private $product = null;

    /**
     * RemoveSession constructor.
     * @param SplSubject $splSubject
     * @param Product $product
     */
    public function __construct(SplSubject $splSubject, Product $product)
    {
        parent::__construct($splSubject);
        $this->product = $product;
    }

    public function doUpdate($observer)
    {
        if ($observer->getCartRepository() instanceof CartRepository) {
            $observer->getCartRepository()->remove($this->product);
            return true;
        }
        return false;
    }
}