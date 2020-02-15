<?php

namespace EEV\Forms\Classes;

use EEV\Forms\Classes\Fields\Field;
use EEV\Forms\Classes\Handlers\FormHandler;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;

class Form
{
    protected $name;

    protected $displayName;

    protected $fields = [];

    protected $handlers = [];

    protected $successMessage = '';

    protected $errorMessage = '';

    protected $attributesNames = [];

    protected $submitText;

    protected $showTitle = false;

    protected $textBefore = '';

    protected $textAfter = '';

    protected $textBeforeSubmit = '';

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function make($name)
    {
        return new self($name);
    }

    public static function getFormsList()
    {
        $formsArray = Config::get('eev.forms::forms');

        if (empty($formsArray)) {
            return [];
        }

        $list = [];

        foreach ($formsArray as $form) {
            /**
             * @var Form $form
             */
            $list[$form->getName()] = ($form->getDisplayName()) ? $form->getDisplayName() : $form->getName();
        }

        return $list;
    }

    /**
     * @param $name
     * @return Form|null
     */
    public static function get($name)
    {
        $formsArray = Config::get('eev.forms::forms');

        if (empty($formsArray)) {
            return null;
        }

        foreach ($formsArray as $form) {
            /**
             * @var Form $form
             */
            if ($form->getName() === $name) {
                return $form;
            }
        }

        return null;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function addField(Field $field)
    {
        $this->fields[] = $field;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function addHandler(FormHandler $handler)
    {
        $this->handlers[] = $handler;
        return $this;
    }

    public function handle($data)
    {

        Event::fire('eev.forms.beforeHandle', [$data]);

        if (empty($this->handlers)) {
            return;
        }

        foreach ($this->handlers as $handler) {
            $handler->handle($data);
        }

        Event::fire('eev.forms.afterHandle', [$data]);
    }

    public function getRules()
    {
        if (empty($this->getFields())) {
            return [];
        }

        $rules = [];

        foreach ($this->getFields() as $field) {
            /**
             * @var Field $field
             */
            $rules[$field->getName()] = $field->getValidationRules();
        }

        return $rules;
    }

    public function setSuccessMessage($message)
    {
        $this->successMessage = $message;
        return $this;
    }

    public function getSuccessMessage()
    {

        if ($this->successMessage === false) {
            return '';
        }

        if ($this->successMessage) {
            return $this->successMessage;
        }

        return Lang::get('eev.forms::lang.messages.success');
    }

    public function setErrorMessage($message)
    {
        $this->errorMessage = $message;
        return $this;
    }

    public function getErrorMessage()
    {
        if ($this->errorMessage === false) {
            return '';
        }

        if ($this->errorMessage) {
            return $this->errorMessage;
        }

        return Lang::get('eev.forms::lang.messages.error');
    }

    public function setAttributeNames($names)
    {
        $this->attributesNames = $names;
        return $this;
    }

    public function getAttributeNames()
    {
        return $this->attributesNames;
    }

    public function setSubmitText($text)
    {
        $this->submitText = $text;
        return $this;
    }

    public function getSubmitText()
    {
        return $this->submitText;
    }

    public function hasFieldType($type)
    {
        foreach ($this->fields as $field) {
            /**
             * @var Field $field
             */
            if ($field->getTypeName() === $type) {
                return true;
            }

            return false;
        }
    }

    public function showTitle() {
        $this->showTitle = true;
        return $this;
    }

    public function isShowTitle() {
        return $this->showTitle;
    }

    public function setTextBefore($text) {
        $this->textBefore = $text;
        return $this;
    }

    public function getTextBefore() {
        return $this->textBefore;
    }

    public function setTextAfter($text) {
        $this->textAfter = $text;
        return $this;
    }

    public function getTextAfter() {
        return $this->textAfter;
    }

    public function setTextBeforeSubmit($text) {
        $this->textBeforeSubmit = $text;
        return $this;
    }

    public function getTextBeforeSubmit() {
        return $this->textBeforeSubmit;
    }
}