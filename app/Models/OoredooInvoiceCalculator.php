<?php
namespace App\Services\InternetServiceProvider;

use App\Models\WifiPlan;

class OoredooInvoiceCalculator implements InternetServiceProviderInterface
{
    private $wifiPlan;
    private $month;

    public function __construct(WifiPlan $wifiPlan)
    {
        $this->wifiPlan = $wifiPlan;
    }

    public function setMonth(int $month)
    {
        $this->month = $month;
    }

    public function calculateTotalAmount(): float|int
    {
        $basePrice = $this->wifiPlan->getBasePrice();
        $dataLimit = $this->wifiPlan->getDataLimit();
        $overageCharge = $this->wifiPlan->getOverageCharge();

        $usage = 130; // Example dynamic usage value
        
        $invoiceAmount = $basePrice;

        if ($usage > $dataLimit) {
            $excessData = $usage - $dataLimit;
            $invoiceAmount += $excessData * $overageCharge;
        }

        return $invoiceAmount;
    }
}
