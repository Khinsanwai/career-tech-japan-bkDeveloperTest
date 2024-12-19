<?php

namespace Tests\Feature;

use App\Services\InternetServiceProvider\OoredooService;
use PHPUnit\Framework\TestCase;

class OoredooServiceTest extends TestCase
{
    public function test_ooredoo_invoice_amount_calculation()
    {
        // Create an instance of the OoredooService
        $ooredooService = new OoredooService();

        // Set the month for calculation
        $ooredooService->setMonth(11);

        // Calculate the invoice amount
        $invoiceAmount = $ooredooService->calculateTotalAmount();

        // Assert that the invoice amount is a number (replace with expected value)
        $this->assertIsFloat($invoiceAmount);
        $this->assertEquals(1200.00, $invoiceAmount);  // Replace with expected value
    }
}
