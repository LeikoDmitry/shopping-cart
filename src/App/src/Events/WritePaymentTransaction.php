<?php


namespace App\Events;


use App\Model\Payment;
use SplSubject;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Hydrator\Reflection;

class WritePaymentTransaction extends EventObserver
{
    /**
     * @var Payment
     */
    private $payment;

    /**
     * WritePaymentTransaction constructor.
     * @param SplSubject $splSubject
     * @param Payment $payment
     */
    public function __construct(SplSubject $splSubject, Payment $payment)
    {
        parent::__construct($splSubject);
        $this->payment = $payment;
    }

    /**
     * @param $subject
     * @return mixed|null
     */
    public function doUpdate($subject)
    {
        $insert = new Insert('payment');
        $hydrate = new Reflection();
        $data = $hydrate->extract($this->payment);
        $insert->values($data);
        $sql = new Sql($subject->getAdapter());
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
        return $result->getGeneratedValue();
    }
}