<?php

namespace EEV\Forms;

use EEV\Forms\Classes\Rules\ReCaptcha;
use EEV\Forms\Components\Form;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = ['EEV.Core'];

    public function boot()
    {
        Event::listen('cms.page.beforeDisplay', function ($controller, $action, $params) {
            $controller->addJs('https://www.google.com/recaptcha/api.js');
        });

        Validator::extend('recaptcha', ReCaptcha::class);

        parent::boot();
    }

    public function registerComponents()
    {
        return [
            Form::class => 'form',
        ];
    }

}