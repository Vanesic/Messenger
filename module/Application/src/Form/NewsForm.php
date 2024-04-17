<?php

declare(strict_types=1);

namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

class NewsForm extends Form
{
    const NEWS_FORM = 'news';

    public function __construct($name = null)
    {
        parent::__construct(self::NEWS_FORM);

        $this->add([
            'type'       => Element\File::class,
            'name'       => 'fileNews',
            'attributes' => [
            'id'    => 'fileNews',
            'class' => 'photo btn',
            ],
        ]);

        $this->add([
            'name'       => 'topicInput',
            'type'       => 'text',
            'attributes' => [
                'placeholder' => '',
                'required'    => 'true',
                'class'       => 'form-control',
            ],
        ]);

        $this->add([
            'name'       => 'infoInput',
            'type'       => 'text',
            'attributes' => [
                'placeholder' => '',
                'required'    => 'true',
                'class'       => 'form-control',
            ],
        ]);
    }
}