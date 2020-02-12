<?php

use EEV\Forms\Classes\Fields\Field;
use EEV\Forms\Classes\Form;
use EEV\Forms\Classes\Handlers\Email;
use EEV\Forms\Classes\Handlers\Model;
use EEV\Leads\Classes\LeadFormHandler;
use EEV\Leads\Models\Lead;

return [
    'recaptcha' => [
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
        'site_key'   => env('RECAPTCHA_SITE_KEY'),
    ],
    'forms' => [],
];
