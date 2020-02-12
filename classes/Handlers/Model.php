<?php

namespace EEV\Forms\Classes\Handlers;

use Illuminate\Support\Facades\Config;

class Model implements FormHandler
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function handle($data)
    {
        if (empty($this->config['model'])) {
            return;
        }

        if ( ! class_exists($this->config['model'])) {
            return;
        }

        if (empty($this->config['map'])) {
            return;
        }

        $model = new $this->config['model'];
        $model->fill($this->getModelArray($data));
        $model->save();
    }

    protected function getModelArray($data)
    {
        $result = [];

        foreach ($this->config['map'] as $modelFieldName => $dataFieldName) {
            if (isset($data[$dataFieldName])) {
                if (is_array($data[$dataFieldName])) {
                    $result[$modelFieldName] = join(', ', $data[$dataFieldName]);
                } else {
                    $result[$modelFieldName] = $data[$dataFieldName];
                }
            }
        }

        return $result;
    }

}