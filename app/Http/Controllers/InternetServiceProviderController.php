<?php

namespace App\Http\Controllers;

use App\Models\WifiPlan;
use App\Services\InternetServiceProvider\MPTInvoiceCalculator;
use App\Services\InternetServiceProvider\OoredooInvoiceCalculator;
use Illuminate\Http\Request;
use App\Services\InternetServiceProvider\InternetServiceProviderInterface;

class InternetServiceProviderController extends Controller
{
    /**
     * Calculate the invoice amount for the specified internet service provider (e.g., MPT, Ooredoo).
     */
    public function getInvoiceAmount(Request $request, $entity)
    {
        // Validate the request parameters
        $validated = $request->validate([
            'usage' => 'required|numeric|min:0', // Ensure valid usage data
            'month' => 'nullable|integer|min:1|max:12', // Ensure valid month (default to 1 if not provided)
        ]);

        // Set default month if not provided
        $month = $validated['month'] ?? 1;
        $usage = $validated['usage'];

        // Determine the service provider and create the appropriate calculator
        $calculator = $this->getInvoiceCalculator($entity, $usage, $month);

        if (!$calculator) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid internet service provider.',
            ], 400);
        }

        // Calculate the total invoice amount
        $invoiceAmount = $calculator->calculateTotalAmount();

        return response()->json([
            'provider' => ucfirst($entity), // Capitalize the provider name (e.g., MPT, Ooredoo)
            'invoice_amount' => $invoiceAmount,
        ]);
    }

    /**
     * Dynamically select the appropriate invoice calculator based on the entity.
     *
     * @param string $entity
     * @param float $usage
     * @param int $month
     * @return InternetServiceProviderInterface|null
     */
    private function getInvoiceCalculator(string $entity, float $usage, int $month): ?InternetServiceProviderInterface
    {
        switch (strtolower($entity)) {
            case 'mpt':
                $wifiPlan = new WifiPlan(30, 100, 2); // Example MPT plan (Base price 30, 100GB limit, 2 per GB)
                $calculator = new MPTInvoiceCalculator($wifiPlan);
                break;

            case 'ooredoo':
                $wifiPlan = new WifiPlan(40, 150, 1.5); // Example Ooredoo plan (Base price 40, 150GB limit, 1.5 per GB)
                $calculator = new OoredooInvoiceCalculator($wifiPlan);
                break;

            default:
                return null; // Return null if no valid entity is found
        }

        $calculator->setMonth($month);
        return $calculator;
    }
}

