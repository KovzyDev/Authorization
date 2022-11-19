<?php

namespace App\Payment;

abstract class Payment
{
    protected $config;

    public function __construct(Object $config) {
        $this->validateConfig($config);
        $this->config = $config;
        $this->prepare();
    }

    protected abstract function validateConfig(Object $config) : void;
    protected abstract function prepare() : void;
    public abstract function saveCard(Object $config) : Object;
}