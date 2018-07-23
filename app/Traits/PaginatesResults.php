<?php

namespace App\Traits;


trait PaginatesResults
{

    /**
     * @var int
     */
    public $per_page;

    /**
     * @var string
     */
    public $order_by;

    /**
     * @var string
     */
    public $direction;


    private function setDefaultPagination ()
    {
        $this->setPerPage();
        $this->setOrderBy();
        $this->setDirection();
    }

    /**
     * @param int $default
     * @return int
     */
    private function setPerPage ($default = 20)
    {
        $this->per_page         = !is_null(request()->per_page) ? request()->per_page : $default;
    }

    /**
     * @param string $default
     * @return string
     */
    private function setOrderBy ($default = 'id')
    {
        $this->order_by         = !is_null(request()->order_by) ? request()->order_by : $default;
    }

    /**
     * @param string $default
     * @return string
     */
    private function setDirection ($default = 'asc')
    {
        $this->direction        = !is_null(request()->direction) ? request()->direction : $default;
    }

    private function getPaginationValidationRules ($order_bys = 'id')
    {
        return [
            'page'                      => 'nullable|integer',
            'per_page'                  => 'nullable|integer',
            'order_by'                  => 'nullable|string|in:' . $order_bys,
            'direction'                 => 'nullable|string|in:asc,desc',
        ];
    }
}
