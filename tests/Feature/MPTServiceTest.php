<?php

namespace Tests\Feature;

use App\Services\InternetServiceProvider\MPTService;
use PHPUnit\Framework\TestCase;

class MPTServiceTest extends TestCase
{
    public function test_mpt_invoice_amount_calculation()
    {
        // Create an instance of the MPTService
        $mptService = new MPTService();

        // Set the month for calculation
        $mptService->setMonth(12);

        // Calculate the invoice amount
        $invoiceAmount = $mptService->calculateTotalAmount();

        // Assert that the invoice amount is a number (replace with expected value)
        $this->assertIsFloat($invoiceAmount);
        $this->assertEquals(1000.00, $invoiceAmount);  // Replace with expected value
    }
}
