<?php

namespace EEV\Forms\Classes\Fields\Types;

use EEV\Forms\Classes\Fields\Field;
use Illuminate\Support\Facades\View;
use League\Flysystem\Exception;

abstract class FieldType
{
    protected $typeName;

    protected $field;

    public function __construct($typeName, Field $field)
    {
        $this->typeName = $typeName;

        $this->field = $field;
    }

    public static function getType($typeName, Field $field) {
        $map = [
            'text' => Text::class,
            'email' => Email::class,
            'number' => Number::class,
            'hidden' => Hidden::class,
            'password' => Password::class,
            'select' => Select::class,
            'textarea' => Textarea::class,
            'checkbox' => Checkbox::class,
            'radio' => Radio::class,
            'recaptcha' => ReCaptcha::class,
        ];

        if (isset($map[$typeName])) {
            return new $map[$typeName]($typeName, $field);
        }

        throw new Exception('Field type not found.');
    }

    public function getHtml()
    {
        $vars = [
            'name' => $this->field->getName(),
            'classes' => $this->classes(),
            'id' => $this->field->getId(),
            'label' => $this->field->getLabel(),
            'attrs' => $this->field->getAttrs(),
            'type' => $this->field->getInputType(),
            'options' => $this->field->getOptions(),
            'value' => $this->field->getValue(),
            'default' => $this->field->getDefault(),
        ];

        if (method_exists($this, 'getVars')) {
            $vars = array_merge($vars, $this->getVars());
        }

        if (method_exists($this, 'getItemClasses')) {
            $vars = array_merge($vars, [
                'item_classes' => !empty($itemClasses = $this->getItemClasses()) ? ' ' . $itemClasses : '',
            ]);
        }

        return View::make('eev.forms::fields.types.' . $this->getTemplateName(), $vars);
    }

    public function getTemplateName() {
        return $this->typeName;
    }

    public function classes()
    {
        return $this->field->classes();
    }

}