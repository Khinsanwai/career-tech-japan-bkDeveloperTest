<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetSalaryRequest;
use App\Services\EmployeeManagement\Employee;
use Symfony\Component\HttpFoundation\Response;

class StaffController extends Controller
{
    public function payroll(GetSalaryRequest $request, Employee $employee)
    {
        try {
            // Assuming that the employee is retrieved using the validated staff_id
            $user = \App\Models\User::findOrFail($request->validated('staff_id'));

            // Get salary using the Employee service
            $employeeService = new Employee($user);
            $salary = $employeeService->getSalary();

            return response()->json([
                'status' => 'success',
                'salary' => $salary,
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to retrieve salary details.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}