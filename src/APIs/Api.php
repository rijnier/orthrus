<?php

namespace MichaelCooke\Orthrus\Apis;

use Eseye;
use MichaelCooke\Orthrus\Orthrus;

class Api
{
    protected $base = null;
    protected $verb = null;
    protected $index = false;
    protected $orthrus = null;
    protected $endpoint = null;
    protected $arguments = null;

    public function __call($method, $arguments)
    {
        if (method_exists($this, $method)) {
            call_user_func_array(array($this, $method), $arguments);
        }

        if ($this->index) {
            return $this->orthrus->invoke($this->verb, "/" . $this->base . "/");
        }

        return $this->orthrus->invoke($this->verb, "/" . $this->base . "/" . $this->endpoint . "/");
    }
}
