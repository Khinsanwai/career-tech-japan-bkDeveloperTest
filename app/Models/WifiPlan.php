<?php

namespace App\Models;

class WifiPlan
{
    private $basePrice;
    private $dataLimit;
    private $overageCharge;

    public function __construct($basePrice, $dataLimit, $overageCharge)
    {
        $this->basePrice = $basePrice;
        $this->dataLimit = $dataLimit;
        $this->overageCharge = $overageCharge;
    }

    public function getBasePrice()
    {
        return $this->basePrice;
    }

    public function getDataLimit()
    {
        return $this->dataLimit;
    }

    public function getOverageCharge()
    {
        return $this->overageCharge;
    }
}
