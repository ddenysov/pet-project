<?php

namespace Iam\Application\Handlers\Query;

use Iam\Application\Handlers\Query\Projection\UserCredentials;
use Iam\Application\Handlers\Query\Repository\Port\UserCredentialsRepository;
use Psr\Log\LoggerInterface;

class FindUserByEmailQueryHandler
{
    /**
     * @param UserCredentialsRepository $repository
     * @param LoggerInterface $logger
     */
    public function __construct(private UserCredentialsRepository $repository, private LoggerInterface $logger)
    {
    }

    /**
     * @param FindUserByEmailQuery $query
     * @return UserCredentials|null
     */
    public function __invoke(FindUserByEmailQuery $query): ?UserCredentials
    {
        $this->logger->info('Searching credentials by email..');
        $result = $this->repository->findByEmail($query->email);
        if ($result) {
            $this->logger->info('Credentials found for: ' . $query->email, [
                'id' => $result->id,
            ]);
        } else {
            $this->logger->info('Credentials not found for: ' . $query->email);
        }

        return $result;
    }
}