<?php

namespace App\Repository;


use Zend\Db\Sql\Insert;

interface OrderRepositoryInterface
{
    /**
     * Вставка Данных
     * @param $insert Insert
     * @return mixed
     */
    public function insert(Insert $insert);
}