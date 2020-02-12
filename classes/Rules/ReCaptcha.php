<?php

namespace EEV\Forms\Classes\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class ReCaptcha implements Rule
{

    public function passes($attribute, $value)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $data = [
            'secret'   => Config::get('eev.forms::recaptcha.secret_key'),
            'response' => $value,
        ];

        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);

        $verify   = file_get_contents($url, false, $context);
        $response = json_decode($verify);

        if ($response->success == true) {
            return true;
        }

        return false;
    }

    public function validate($attribute, $value, $params)
    {
        return $this->passes($attribute, $value);
    }

    public function message()
    {
        return Lang::get('eev.forms::validate.recaptcha');
    }

}