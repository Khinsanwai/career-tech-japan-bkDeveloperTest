<?php

namespace App\Http\Controllers;


use App\Http\Requests\JobApplicationRequest;
use App\Services\EmployeeManagement\Applicant;
use Symfony\Component\HttpFoundation\Response;

class JobController extends Controller
{
  public function apply(JobApplicationRequest $request, Applicant $applicant)
    {
        try {
            $applicant->applyForJob($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Your job application has been submitted successfully.',
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while submitting your job application.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
