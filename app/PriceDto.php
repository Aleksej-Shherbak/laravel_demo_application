<?php

namespace App;

class PriceDto
{
    public function __construct($total, $breakdown)
    {
        $this->total = $total;
        $this->breakdown = $breakdown;
    }

    public int $total;
    /**
     * @var array<int $days, int $price> $breakdown
     */
    public array $breakdown;
}
