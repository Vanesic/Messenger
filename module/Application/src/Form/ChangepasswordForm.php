<?php

declare(strict_types=1);

namespace Application\Form;

use Laminas\Form\Form;


class ChangepasswordForm extends Form
{
    const CHANGE_PASSWORD_FORM = 'changePassword';

    public function __construct($name = null)
    {
        parent::__construct(self::CHANGE_PASSWORD_FORM);

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name'       => 'prevPassword',
            'type'       => 'password',
            'attributes' => [
                'placeholder' => 'Previous password',
                'class'       => 'form-control h-25 mt-2 w-100 fw-normal',
                'required'    => 'true',
            ],
        ]);

        $this->add([
            'name'       => 'newPassword',
            'type'       => 'password',
            'attributes' => [
                'placeholder' => 'New password',
                'class'       => 'form-control h-25 mt-2 w-100 fw-normal',
                'required'    => 'true',
            ],
        ]);

        $this->add([
            'name'       => 'repeatPassword',
            'type'       => 'password',
            'attributes' => [
                'placeholder' => 'Repeat password',
                'class'       => 'form-control h-25 mt-2 w-100 fw-normal',
                'required'    => 'true',
            ],
        ]);

        $this->add([
            'type'       => 'submit',
            'name'       => 'submit',
            'attributes' => [
                'id'    => 'changePasswordButton',
                'class' => 'btn btn-dark btn-lg w-auto text-center mt-5'
            ],
        ]);
    }
}