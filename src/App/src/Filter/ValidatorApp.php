<?php

namespace App\Filter;

use Zend\Db\Adapter\AdapterInterface;
use Zend\I18n\Validator\Alnum;
use Zend\InputFilter\Factory;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\EmailAddress;

class ValidatorApp implements ValidatorInterface
{
    /**
     * @var \Zend\InputFilter\Factory
     */
    private $validator;

    /**
     * @var null
     */
    private $errors = null;

    /**
     * @var null
     */
    private $adapter = null;

    /**
     * ValidatorApp constructor.
     * @param \Zend\InputFilter\Factory $factory
     * @param AdapterInterface $adapter
     */
    public function __construct(Factory $factory, AdapterInterface $adapter)
    {
        $this->validator = $factory;
        $this->adapter   = $adapter;
    }

    /**
     * @return null
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $errors
     * @return mixed
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @param array $post
     * @return bool|mixed
     */
    public function validate(array $post = [])
    {
        $factory = $this->validator->createInputFilter($this->rules());
        $factory->setData($post);
        if (! $factory->isValid()) {
            return $this->setErrors($factory->getMessages());
        }
        return $factory->getValues();
    }

    public function rules()
    {
        return [
            'email' => [
                'name'       => 'email',
                'required'   => true,
                'validators' => [
                    [
                        'name' => EmailAddress::class,
                    ],
                    [
                        'name' => NoRecordExists::class,
                        'options' => [
                            'table'   => 'customers',
                            'field'   => 'email',
                            'adapter' => $this->adapter,
                        ],
                    ],
                ],
            ],
            'name' => [
                'name'       => 'name',
                'required'   => true,
                'validators' => [
                    [
                        'name' => Alnum::class,
                        'options' => [
                            'allowWhiteSpace' => true,
                        ]
                    ],
                ],
            ],
            'address1' => [
                'name'       => 'address1',
                'required'   => true,
                'validators' => [
                    [
                        'name' => Alnum::class,
                        'options' => [
                            'allowWhiteSpace' => true,
                        ]
                    ],
                ],
            ],
            'address2' => [
                'name'       => 'address2',
                'required'   => false,
                'validators' => [
                    [
                        'name' => Alnum::class,
                        'options' => [
                            'allowWhiteSpace' => true,
                        ]
                    ],
                ],
            ],
            'city' => [
                'name'       => 'city',
                'required'   => true,
                'validators' => [
                    [
                        'name' => Alnum::class,
                        'options' => [
                            'allowWhiteSpace' => true,
                        ]
                    ],
                ],
            ],
            'postal_code' => [
                'name'       => 'postal_code',
                'required'   => true,
                'validators' => [
                    [
                        'name' => Alnum::class,
                        'options' => [
                            'allowWhiteSpace' => true,
                        ]
                    ],
                ],
            ],
        ];
    }
}