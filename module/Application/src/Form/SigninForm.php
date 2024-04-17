<?php

declare(strict_types=1);

namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class SigninForm extends Form
{
    const SIGN_FORM = 'sign';

    public function __construct($name = null)
    {
        parent::__construct(self::SIGN_FORM);

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name'       => 'emailSignIn',
            'type'       => 'email',
            'attributes' => [
                'placeholder' => 'Email',
                'class'       => 'form-control mx-auto w-25 fw-normal',
                'required'    => 'true',
            ],
        ]);

        $this->add([
            'name'       => 'emailForgotPassword',
            'type'       => 'email',
            'attributes' => [
                'class'       => 'form-control mx-auto w-25 fw-normal',
                'placeholder' => 'Email',
                'required'    => 'true'
            ],
        ]);

        $this->add([
            'name'       => 'emailRegister',
            'type'       => 'email',
            'attributes' => [
                'class'       => 'form-control ms-0 w-25 fw-normal',
                'placeholder' => 'Email',
                'required'    => 'true',
            ],
        ]);

        $this->add([
            'name'       => 'passwordSignIn',
            'type'       => 'password',
            'attributes' => [
                'class'       => 'form-control mx-auto w-25 fw-normal',
                'placeholder' => 'Password',
                'required'    => 'true',
            ],
        ]);

        /**
         * The data must be taken from the database
         */
        $this->add([
            'type'    => Element\Select::class,
            'id'      => 'dropdownPost',
            'name'    => 'dropdown',
            'options' => [
                'empty_option' => 'Set post',
            ],

            'attributes' => [
                'class'    => 'form-select text-center bg-light ',
                'required' => 'true'
            ],
        ]);

        $this->add([
            'name'       => 'passwordRegister',
            'type'       => 'password',
            'attributes' => [
                'class'       => 'form-control w-25 fw-normal',
                'placeholder' => 'Password',
                'required'    => 'true',
            ],
        ]);

        $this->add([
            'name'       => 'repeatPassword',
            'type'       => 'password',
            'attributes' => [
                'class'       => 'form-control w-25 fw-normal',
                'placeholder' => 'Repeat password',
                'required'    => 'true',
            ],
        ]);

        $this->add([
            'type'       => 'submit',
            'name'       => 'submit',
            'attributes' => [
                'id'    => 'validationSignIn',
                'class' => 'btn btn-dark btn-lg mt-5 w-25 text-center',
            ],
        ]);

        $this->add([
            'type'       => 'submit',
            'name'       => 'submitRegister',
            'attributes' => [
                'id'    => 'validateRegister',
                'class' => 'btn btn-success btn-lg mt-5 w-25 text-center',
            ],
        ]);
    }
}