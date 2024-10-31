<?php

namespace Track\Application\Repository\Read;

use Common\Application\Repository\Criteria\Criteria;
use Common\Application\Repository\Page\Order;
use Common\Application\Repository\Page\Page;
use Track\Domain\ValueObject\TrackId;

class TrackReadRepository
{
    /**
     * @param TrackId $id
     * @return void
     */
    public function findById(TrackId $id)
    {
        //
    }

    public function findBy(Criteria $criteria, Order $order, Page $page)
    {

    }
}