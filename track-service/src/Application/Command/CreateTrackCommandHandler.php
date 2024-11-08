<?php

namespace Track\Application\Command;

use Common\Application\Container\Port\ServiceContainer;
use Common\Application\Handlers\Command\CommandHandler;
use Psr\Log\LoggerInterface;
use Track\Domain\Entity\Track;
use Track\Domain\Repository\Port\TrackRepository;
use Track\Domain\ValueObject\OwnerId;
use Track\Domain\ValueObject\TrackAccessType;
use Track\Domain\ValueObject\TrackName;
use Track\Domain\ValueObject\TrackPath;

class CreateTrackCommandHandler extends CommandHandler
{
    public function __construct(
        ServiceContainer $container,
        LoggerInterface $logger,
        private TrackRepository $trackRepository,
    )
    {
        parent::__construct($container, $logger);
    }

    /**
     * @param CreateTrackCommand $command
     * @return void
     * @throws \Exception
     */
    protected function handle(CreateTrackCommand $command): void
    {
        $path = new TrackPath($command->path);
        dd($path->getLength());

        $track = Track::create(
            ownerId: new OwnerId($command->ownerId),
            trackName: new TrackName($command->name),
            trackAccessType: new TrackAccessType($command->accessType),
            trackPath: new TrackPath($command->path),
        );

        $this->trackRepository->save($track);
    }
}