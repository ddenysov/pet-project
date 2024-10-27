<?php

namespace Track\Application\Command;

use Common\Application\Handlers\Command\Port\Command;

class CreateTrackCommand implements Command
{
    public string $name;
    public string $creatorId;
    public string $accessType;
    public array $path;

    /**
     * @param string $name
     * @param string $creatorId
     * @param string $accessType
     * @param array $path
     */
    public function __construct(string $name, string $creatorId, string $accessType, array $path)
    {
        $this->name       = $name;
        $this->creatorId  = $creatorId;
        $this->accessType = $accessType;
        $this->path       = $path;
    }

    public function toArray(): array
    {
        return [];
    }
}