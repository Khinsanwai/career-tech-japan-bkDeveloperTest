<?php

namespace App\Services\EmployeeManagement;

class Applicant implements NonEmployeeInterface
{
   
    public function applyForJob(array $jobDetails): bool
    {

        \App\Models\JobApplication::create([
            'name' => $jobDetails['name'],
            'email' => $jobDetails['email'],
            'phone' => $jobDetails['phone'],
            'resume_path' => $jobDetails['resume_path'],
            'job_position' => $jobDetails['job_position'],
        ]);

        return true; 
    }
}