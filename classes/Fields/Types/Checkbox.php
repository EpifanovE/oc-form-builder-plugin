<?php

namespace EEV\Forms\Classes\Fields\Types;

class Checkbox extends FieldType
{
    public function getTemplateName() {
        return 'checkbox';
    }

    public function classes()
    {
        $parentClasses = $this->field->classes();

        $classes = [
            'form-field_checkbox',
        ];

        return $parentClasses . ' ' . join(' ', $classes);

    }
}