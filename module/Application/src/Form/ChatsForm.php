<?php

declare(strict_types=1);

namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class ChatsForm extends Form
{
    const MESSAGES_FORM = 'messages';

    public function __construct($name = null)
    {
        parent::__construct(self::MESSAGES_FORM);

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
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

        $this->add([
            'name'       => 'search',
            'type'       => 'search',
            'attributes' => [
                'placeholder' => 'Full name or number or email',
                'class'       => 'form-control w-100 me-2',
                'required'    => 'true',
            ],
        ]);

        $this->add([
            'type'       => 'submit',
            'name'       => 'submit',
            'attributes' => [
                'id'    => 'search',
                'class' => 'btn ms-2 btn-outline-success w-25',
            ],
        ]);
    }
}