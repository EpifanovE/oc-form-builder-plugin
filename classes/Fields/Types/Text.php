<?php

namespace EEV\Forms\Classes\Fields\Types;

use Illuminate\Support\Facades\View;

class Text extends FieldType
{
    public function classes()
    {
        $parentClasses = $this->field->classes();

        $classes = [
            'form-field_text',
        ];

        return $parentClasses . ' ' . join(' ', $classes);

    }
}