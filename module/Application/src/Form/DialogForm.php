<?php

declare(strict_types=1);

namespace Application\Form;

use Laminas\Form\Form;

class DialogForm extends Form
{
    const DIALOG_FORM = 'chat';

    public function __construct($name = null)
    {
        parent::__construct(self::DIALOG_FORM);

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name'       => 'message',
            'type'       => 'text',
            'attributes' => [
                'placeholder' => 'Enter message',
                'class'       => 'form-control me-2',
            ],
        ]);

        $this->add([
            'type'       => 'submit',
            'name'       => 'send',
            'attributes' => [
                'id'    => 'send',
                'class' => 'btn btn-primary btn-lg rounded-5',
            ],
        ]);
    }
}