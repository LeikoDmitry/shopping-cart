<?php
namespace App\Events;

use App\Repository\CartRepository;
use SplObserver;
use Zend\Db\Adapter\AdapterInterface;

class HandleEvent implements \SplSubject
{
    private $storage = [];
    
    protected $cartRepository;

    protected $adapter;

    public function __construct(CartRepository $cartRepository, AdapterInterface $adapter)
    {
        $this->storage = new \SplObjectStorage();
        $this->cartRepository = $cartRepository;
        $this->adapter = $adapter;
    }

    public function attach(SplObserver $observer)
    {
        $this->storage->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->storage->detach($observer);
    }

    public function notify()
    {
        foreach ($this->storage as $object) {
            $object->update($this);
        }
    }

    /**
     * @return CartRepository
     */
    public function getCartRepository(): CartRepository
    {
        return $this->cartRepository;
    }

    /**
     * @param CartRepository $cartRepository
     */
    public function setCartRepository(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter(): AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @param AdapterInterface $adapter
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }
}