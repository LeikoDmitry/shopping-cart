<?php


namespace App\Repository;

/**
 * Interface ProductsRepositoryInterface
 * @package App\Repository
 */
interface ProductsRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getProducts();

    /**
     * @param string $id
     * @return mixed
     */
    public function getProductById(string $id);
}