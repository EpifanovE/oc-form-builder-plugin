<?php

namespace EEV\Forms\Classes\Fields\Types;

class Email extends FieldType
{
    public function getTemplateName() {
        return 'text';
    }

    public function classes()
    {
        $parentClasses = $this->field->classes();

        $classes = [
            'form-field_email',
        ];

        return $parentClasses . ' ' . join(' ', $classes);

    }
}