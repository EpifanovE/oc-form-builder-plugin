<?php

namespace EEV\Forms\Classes\Fields\Types;

class Textarea extends FieldType
{
    public function getTemplateName() {
        return 'textarea';
    }

    public function classes()
    {
        $parentClasses = $this->field->classes();

        $classes = [
            'form-field_textarea',
        ];

        return $parentClasses . ' ' . join(' ', $classes);

    }
}