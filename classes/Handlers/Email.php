<?php

namespace EEV\Forms\Classes\Handlers;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class Email implements FormHandler
{

    protected $config;

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    public function handle($data)
    {
        Mail::send($this->getTemplate(), ['data' => $this->getData($data)], function ($message) {
            $message->to($this->config['recipients']);
            $message->subject($this->getSubject());
        });
    }

    protected function getTemplate()
    {
        if (isset($this->config['template'])) {
            return $this->config['template'];
        }

        return 'eev.forms::mail.form_submit';
    }

    protected function getData($data)
    {
        if (empty($this->config['labels'])) {
            return $this->cleanData($data);
        }

        $data   = $this->cleanData($data);
        $result = [];

        foreach ($data as $key => $value) {
            if (isset($this->config['labels'][$key])) {
                $result['fields'][$key]['label'] = $this->config['labels'][$key];
            }

            if (is_array($value)) {
                $result['fields'][$key]['value'] = join(', ', $value);
            } else {
                $result['fields'][$key]['value'] = $value;
            }
        }

        $result['subject'] = $this->getSubject();
        $result['desc']    = $this->getDesc();

        return $result;
    }

    protected function cleanData($data)
    {
        if (empty($this->config['exclude'])) {
            return $data;
        }

        foreach ($data as $key => $value) {
            if (in_array($key, $this->config['exclude'])) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    public function getSubject()
    {
        if ( ! empty($this->config['subject'])) {
            return $this->config['subject'];
        }

        return Lang::get('eev.forms::lang.notification.form_submit_subject');
    }

    public function getDesc()
    {
        if ( ! empty($this->config['desc'])) {
            return $this->config['desc'];
        }

        if (Lang::has('eev.forms::lang.notification.form_submit_desc')) {
            return Lang::get('eev.forms::lang.notification.form_submit_desc');
        }

        return '';
    }

}