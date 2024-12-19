<?php

namespace App\Services\EmployeeManagement;

interface NonEmployeeInterface
{
    public function applyForJob(array $jobDetails): bool;  
}