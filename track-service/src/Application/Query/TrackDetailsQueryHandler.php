<?php

namespace Track\Application\Query;

use Track\Application\Query\Port\TrackQueryBuilder;

class TrackDetailsQueryHandler
{
    /**
     * @param TrackQueryBuilder $queryBuilder
     */
    public function __construct(
        private TrackQueryBuilder $queryBuilder
    )
    {
    }

    /**
     * @param TrackDetailsQuery $query
     * @return array
     */
    public function __invoke(TrackDetailsQuery $query): array
    {
        return $this->queryBuilder->from('track')
            ->id($query->getId());
    }
}