<?php

namespace Ride\Application\Handlers\Query;

use Common\Application\View\View;

readonly class RideView extends View
{

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'           => $this->data['id'],
            'name'         => $this->data['name'],
            'description'  => $this->data['description'],
            'joined'       => in_array($this->identity->getId()?->toString(), json_decode($this->data['riders'], true)),
            'pending_join' => in_array($this->identity->getId()?->toString(), json_decode($this->data['pending_riders'], true)),
        ];
    }
}