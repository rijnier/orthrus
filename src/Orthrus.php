<?php

namespace MichaelCooke\Orthrus;

use Eseye;
use Carbon\Carbon;
use Seat\Eseye\Containers\EsiResponse;

class Orthrus
{
    protected $eseye;
    protected $resetRefreshToken = false;
    protected $response = null;

    public function __construct()
    {
        $this->eseye = new Eseye;
    }

    public function setRefreshToken(String $token): Orthrus
    {
        $this->eseye::setRefreshToken($token);

        return $this;
    }

    public function withRefreshToken(String $token): Orthrus
    {
        $this->resetRefreshToken = true;

        return $this->setRefreshToken($token);
    }

    public function resetRefreshToken(): bool
    {
        if ($this->resetRefreshToken) {
            $this->setRefreshToken(config('eseye.refresh_token'));

            return true;
        }

        return false;
    }

    public function invoke(String $verb, String $endpoint, array $uri_data = null, array $body = null, array $query = null): EsiResponse
    {
        if ($body != null) {
            $this->eseye::setBody($body);
        }

        if ($query != null) {
            $this->eseye::setQueryString($query);
        }

        if ($uri_data != null) {
            return $this->eseye::invoke($verb, $endpoint, $uri_data);
        }

        return $this->eseye::invoke($verb, $endpoint);
    }

    public function setResponse(EsiResponse $esiResponse): bool
    {
        $this->response = $esiResponse;

        return true;
    }

    public function response(): EsiResponse
    {
        return $this->response;
    }

    public function responseExpires(): Carbon
    {
        return $this->response->expires();
    }

    public function responseCode(): Int
    {
        return $this->response->getErrorCode();
    }

    public function responseErrorMessage(): ?String
    {
        return $this->response->error();
    }

    public function __call(String $method, array $arguments)
    {
        $class = 'MichaelCooke\\Orthrus\\APIs\\' . ucfirst($method);
        $api = new $class(...$arguments);

        if ($method == 'search' ||
            $method == 'status' ||
            $method == 'route' ||
            $method == 'incursions') {
            return $api->execute();
        }

        return $api;
    }
}
