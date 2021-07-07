<?php

namespace App\Utils;

use Dflydev\DotAccessData\Data;

class Config
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = new Data($data);
    }

    public function get($path, $default = null)
    {
        return $this->data->get($path, $default);
    }

    public function set($path, $value)
    {
        $this->data->set($path, $value);
    }

    public function has($path)
    {
        return $this->data->has($path);
    }

    public function export()
    {
        return $this->data->export();
    }
}
