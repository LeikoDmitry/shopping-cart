<?php

namespace App\Filter;

interface ValidatorInterface
{
    /**
     * Получение запроса POST
     * @param array $post
     * @return mixed
     */
    public function validate(array $post = []);

    /**
     * Возращает ошибки
     * @return mixed
     */
    public function getErrors();

    /**
     * @param $errors
     * @return mixed
     */
    public function setErrors($errors);
}