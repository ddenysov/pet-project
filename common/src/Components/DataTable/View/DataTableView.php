<?php

namespace Common\Components\DataTable\View;

use Common\Application\View\View;

readonly class DataTableView extends View
{
    public function __construct(private View $view)
    {
        parent::__construct($this->view->toArray());
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'total' => 100,
        ];
    }
}