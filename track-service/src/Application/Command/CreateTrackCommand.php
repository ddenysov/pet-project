<?php

namespace Track\Application\Command;

use Common\Application\Handlers\Command\Port\Command;

class CreateTrackCommand implements Command
{
    public string $name;
    public string $ownerId;
    public string $accessType;
    public array  $path;

    /**
     * @param string $name
     * @param string $ownerId
     * @param string $accessType
     * @param array $path
     */
    public function __construct(string $name, string $ownerId, string $accessType, array $path)
    {
        $this->name       = $name;
        $this->ownerId    = $ownerId;
        $this->accessType = $accessType;
        $this->path       = $path;
    }

    public function toArray(): array
    {
        return [];
    }
}