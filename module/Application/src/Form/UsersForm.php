<?php

declare(strict_types=1);

namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class UsersForm extends Form
{
    const USERS_FORM = 'users';

    public function __construct($name = null)
    {
        parent::__construct(self::USERS_FORM);

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name'       => 'searchLine',
            'attributes' => [
                'id'          => 'searchLine',
                'placeholder' => 'Full name or number or email',
                'class'       => 'form-control w-100 me-2',
                'aria-label'  => 'Search',
                'required'    => 'true',
            ],
        ]);

        $this->add([
            'type'       => Element\Select::class,
            'id'         => 'dropdownGender',
            'name'       => 'dropdownGender',
            'options'    => [
                'empty_option'  => 'Gender',
                'value_options' => [
                    '2' => 'Male',
                    '1' => 'Female',
                ],
            ],
            'attributes' => [
                'class' => 'form-select bg-light w-auto border-0',
            ],
        ]);

        $this->add([
            'type'       => Element\Date::class,
            'name'       => 'date[]',
            'options'    => [
                'format' => 'Y-m-d',
            ],
            'attributes' => [
                'min'   => '1900-01-01',
                'max'   => '2030-01-01',
                'step'  => '1',
                'class' => 'form-control',
            ],
        ]);

        /**
	 * Values must be taken from data base
	 */
        $this->add([
            'type'       => Element\Select::class,
            'id'         => 'dropdownPost',
            'name'       => 'dropdownPost',
            'attributes' => [
                'class'    => 'select',
                'multiple' => true,
            ],
        ]);


        $this->add([
            'type'       => 'submit',
            'name'       => 'submit',
            'attributes' => [
                'id'    => 'searchButton',
                'class' => 'btn ms-2 btn-outline-success w-25',
            ],
        ]);
    }
}