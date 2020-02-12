<?php

namespace EEV\Forms\Classes\Fields\Types;

class Radio extends FieldType
{
    public function getTemplateName() {
        return 'checkbox';
    }

    public function classes()
    {
        $parentClasses = $this->field->classes();

        $classes = [
            'form-field_radio',
        ];

        return $parentClasses . ' ' . join(' ', $classes);

    }

    public function getItemClasses() {
        $classes = [];

        if ($width = $this->field->getItemWidth()) {
            $classes[] = 'form-field__item_w_' . $width;
        }

        return join(' ', $classes);
    }
}