<?php

namespace App\Events;


use SplSubject;

abstract class EventObserver implements \SplObserver
{
    public function __construct(SplSubject $splSubject)
    {
        $splSubject->attach($this);
    }

    public function update(SplSubject $subject)
    {
        $this->doUpdate($subject);
    }
    abstract public function doUpdate($subject);
}