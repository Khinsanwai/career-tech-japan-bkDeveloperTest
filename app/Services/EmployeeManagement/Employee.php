<?php

namespace App\Services\EmployeeManagement;

class Employee implements EmployeeInterface
{
    protected $user;

    public function __construct(\App\Models\User $user)
    {
        $this->user = $user;
    }

    public function getSalary(): float
    {
        return $this->user->salary;
    }
}