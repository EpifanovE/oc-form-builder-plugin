<?php

namespace EEV\Forms\Classes\Fields;

use EEV\Forms\Classes\Fields\Types\FieldType;

class Field
{
    protected $name;

    /**
     * @var FieldType
     */
    protected $type;

    protected $typeName;

    protected $params = [];

    protected $rules = [];

    protected $attrs = [];

    protected $label;

    protected $options = [];

    protected $classes = [];

    protected $default;

    protected $width;

    protected $itemWidth;

    public function __construct($name, $type, $params = [])
    {
        $this->name     = $name;
        $this->typeName = $type;
        $this->type     = FieldType::getType($type, $this);
        $this->params   = $params;

        if ( ! empty($params['required'])) {
            $this->rules[] = 'required';
        }
    }

    public static function make($name, $type, $params = [])
    {
        return new self($name, $type, $params);
    }

    public function getHtml()
    {
        return $this->type->getHtml();
    }

    public function getInputType()
    {
        $map = [
            'email' => 'email',
        ];

        if (isset($map[$this->typeName])) {
            return $map[$this->typeName];
        }

        return $this->typeName;
    }

    public function getId()
    {
        return 'form-field-' . uniqid();
    }

    public function getName()
    {
        if ($this->typeName === 'checkbox' && count($this->options) > 1) {
            return $this->name . '[]';
        }

        return $this->name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getAttrs()
    {
        $attrs = [];

        if ( ! empty($this->attrs['placeholder'])) {
            $attrs['placeholder'] = $this->attrs['placeholder'];
        }

        if ( ! empty($this->attrs['required'])) {
            $attrs['required'] = 'required';
        }

        if ( ! empty($this->attrs['disabled'])) {
            $attrs['disabled'] = 'disabled';
        }

        if (isset($this->attrs['autocomplete'])) {
            $attrs['autocomplete'] = $this->attrs['autocomplete'] ? 'on' : 'off';
        }

        if ( ! empty($this->attrs['autofocus'])) {
            $attrs['autofocus'] = true;
        }

        if ( ! empty($this->attrs['checked']) && ($this->typeName === 'radio' || $this->typeName === 'checkbox')) {
            $attrs['checked'] = 'checked';
        }

        $maxMinFormats = [
            'number',
            'datetime',
            'date',
            'time',
        ];

        if ( ! empty($this->attrs['max']) && in_array($this->typeName, $maxMinFormats)) {
            $attrs['max'] = $this->attrs['max'];
        }

        if ( ! empty($this->attrs['min']) && in_array($this->typeName, $maxMinFormats)) {
            $attrs['min'] = $this->attrs['min'];
        }

        if ( ! empty($this->attrs['step']) && in_array($this->typeName, $maxMinFormats)) {
            $attrs['step'] = $this->attrs['step'];
        }

        if ( ! empty($this->attrs['maxlength'])) {
            $attrs['maxlength'] = $this->attrs['maxlength'];
        }

        if ( ! empty($this->attrs['readonly'])) {
            $attrs['readonly'] = 'readonly';
        }

        if ( ! empty($this->attrs['value'])) {
            $attrs['value'] = $this->attrs['value'];
        }

        if ( ! empty($this->attrs['rows']) && $this->typeName === 'textarea') {
            $attrs['rows'] = $this->attrs['rows'];
        }

        return $this->getAttrsString($attrs);
    }

    protected function getAttrsString($attrs)
    {
        if (empty($attrs)) {
            return '';
        }

        $result = '';

        foreach ($attrs as $key => $value) {
            $result .= ' ';
            $result .= $key;

            if ( ! empty($value) && $value !== true) {
                $result .= '="' . $value . '"';
            }
        }

        return $result;
    }

    public function classes()
    {
        $classes = [
            'form__field',
            'form-field',
        ];

        if ( ! empty($this->classes)) {
            $classes = array_merge($classes, $this->classes);
        }

        if (isset($this->attrs['required']) || in_array('required', $this->rules)) {
            $classes[] = 'form-field_required';
        }

        $classes = array_merge($classes, $this->getWidthClasses());

        return join(' ', $classes);
    }

    public function getValidationRules()
    {
        return $this->rules;
    }

    public function setValidationRules($rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public function setAttrs($attrs)
    {
        $this->attrs = $attrs;

        return $this;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function setDefault($value)
    {
        $this->default = $value;

        return $this;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function setOptions($options)
    {
        $types = ['select', 'radio', 'checkbox'];

        if ( ! in_array($this->typeName, $types)) {
            return;
        }

        $this->options = $options;

        return $this;
    }

    public function getOptions()
    {
        if (empty($this->options)) {
            return $this->options;
        }

        $result = [];

        foreach ($this->options as $key => $value) {
            if (is_numeric($key)) {
                $result[$value] = $value;
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public function getValue()
    {
        if (isset($this->attrs['value'])) {
            return $this->attrs['value'];
        }

        return '';
    }

    public function setClass($class)
    {
        $this->classes[] = $class;

        return $this;
    }

    public function setItemWidth($width)
    {
        $this->itemWidth = $width;

        return $this;
    }

    public function getItemWidth()
    {
        return $this->itemWidth;
    }

    public function setWidth($width)
    {
        $sizes = [
            3,
            4,
            6,
            8,
            9,
        ];

        if (in_array((int)$width, $sizes)) {
            $this->width = $width;
        }

        return $this;
    }

    protected function getWidthClasses()
    {
        $classes = [];

        if ( ! empty($this->width)) {
            $classes[] = 'form__field_w_' . $this->width;
        }

        return $classes;
    }

    public function getTypeName() {
        return $this->typeName;
    }
}