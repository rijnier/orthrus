<?php

namespace MichaelCooke\Orthrus\Traits;

trait HasIdAndIndex
{
    protected $id = null;

    protected function get()
    {
        $this->verb = "get";
        
        if ($this->id == null) {
            $this->index = true;
        } else {
            $this->endpoint = $this->id;
        }
    }
}
