<?php

namespace Ride\Application\Query;

use Common\Application\View\View;

readonly class RideView extends View
{

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'                => $this->data['id'],
            'name'              => $this->data['name'],
            'description'       => $this->data['description'],
            'start_date_time'   => $this->data['start_date_time'],
            'end_date_time'     => $this->data['end_date_time'],
            'image_url'         => 'http://localhost:8000' . $this->data['image_url'],
            'preview_image_url' => 'http://localhost:8000' . str_ireplace('images/', 'images/preview_', $this->data['image_url']),
            'joined'            => in_array($this->identity->getId()?->toString(), json_decode($this->data['riders'], true)),
            'pending_join'      => in_array($this->identity->getId()?->toString(), json_decode($this->data['pending_riders'], true)),
            'start_location'    => [
                (float) $this->data['start_lat'],
                (float) $this->data['start_lon'],
            ],
            'end_location'    => [
                (float) $this->data['end_lat'],
                (float) $this->data['end_lon'],
            ],
        ];
    }
}