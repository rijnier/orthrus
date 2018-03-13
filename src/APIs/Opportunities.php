<?php

namespace MichaelCooke\Orthrus\Apis;

class Opportunities extends Api
{
    public function __construct()
    {
        $this->base = 'opportunities';
    }

    protected function groups(): void
    {
        $this->endpoint = 'groups';
    }

    protected function group(Int $groupId): void
    {
        $this->endpoint = 'groups/' . $groupId;
    }

    protected function tasks(): void
    {
        $this->endpoint = 'tasks';
    }

    protected function task(Int $taskId): void
    {
        $this->endpoint = 'tasks/' . $taskId;
    }
}
