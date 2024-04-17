<?php

declare(strict_types=1);

namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class EditForm extends Form
{
    const EDIT_FORM = 'edit';

    public function __construct($name = null)
    {
        parent::__construct(self::EDIT_FORM);

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name'       => 'lastNameInput',
            'type'       => 'text',
            'attributes' => [
                'placeholder' => 'Last name',
                'required'    => 'true',
                'class'       => 'form-control',
            ],
        ]);

        $this->add([
            'name'       => 'firstNameInput',
            'type'       => 'text',
            'attributes' => [
                'placeholder' => 'First name',
                'required'    => 'true',
                'class'       => 'form-control',
            ],
        ]);

        $this->add([
            'name'       => 'middleNameInput',
            'type'       => 'text',
            'attributes' => [
                'placeholder' => 'Middle name',
                'required'    => 'true',
                'class'       => 'form-control',
            ],
        ]);

        $this->add([
            'name'       => 'passwordInput',
            'type'       => 'text',
            'attributes' => [
                'placeholder' => 'Password',
                'required'    => 'true',
                'class'       => 'form-control',
            ],
        ]);

        $this->add([
            'name'       => 'skypeInput',
            'type'       => 'text',
            'attributes' => [
                'placeholder' => 'Skype',
                'required'    => 'true',
                'class'       => 'form-control',
            ],
        ]);

        $this->add([
            'type'       => Element\Select::class,
            'id'         => 'dropdownGender',
            'name'       => 'dropdownGender',
            'options'    => [
                'empty_option'  => 'Gender',
                'value_options' => [
                    '1' => 'Male',
                    '0' => 'Female',
                ],
            ],
            'attributes' => [
                'class'    => 'form-select btn-outline-dark w-auto',
                'id'       => 'dropdownMenuGender',
                'required' => true,
            ],
        ]);

        $this->add([
            'type'       => Element\Date::class,
            'name'       => 'date',
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

        $this->add([
            'name'       => 'email[]',
            'type'       => 'email',
            'attributes' => [
                'placeholder' => 'Email',
                'required'    => 'true',
                'class'       => 'form-control fw-normal',
            ],
        ]);

        $this->add([
            'name'       => 'phone[]',
            'type'       => 'tel',
            'attributes' => [
                'placeholder' => 'Phone number',
                'required'    => 'true',
                'class'       => 'form-control fw-normal',
            ],
        ]);

        $this->add([
            'type'       => 'submit',
            'name'       => 'submit',
            'attributes' => [
                'id'    => 'validateSaveChanges',
                'class' => 'btn btn-success btn-lg mt-5 w-auto px-5',
            ],
        ]);

        $this->add([
            'type'       => Element\File::class,
            'name'       => 'file',
            'attributes' => [
                'id'    => 'file',
                'class' => 'photo btn',
            ],
        ]);

        $this->add([
            'type'       => Element\Select::class,
            'name'       => 'active',
            'options'    => [
                'empty_value'   => 'Active',
                'value_options' => [
                    '1' => 'Yes',
                    '0' => 'No',
                ],
            ],
            'attributes' => [
                'class' => 'form-select btn-outline-dark w-auto',
            ],
        ]);

        $this->add([
            'type'        => Element\Select::class,
            'name'        => 'admin',
            'empty_value' => 'Admin',
            'options'     => [
                'value_options' => [
                    '1' => 'Yes',
                    '0' => 'No',
                ],
            ],
            'attributes'  => [
                'class' => 'form-select btn-outline-dark w-auto',
            ],
        ]);
    }
}