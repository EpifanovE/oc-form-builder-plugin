<?php

namespace EEV\Forms\Classes\Fields\Types;

class Number extends FieldType
{
    public function getTemplateName() {
        return 'text';
    }

    public function classes()
    {
        $parentClasses = $this->field->classes();

        $classes = [
            'form-field_number',
        ];

        return $parentClasses . ' ' . join(' ', $classes);

    }
}