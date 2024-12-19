<?php

namespace App\Providers;

use App\Services\InternetServiceProvider\InternetServiceProviderInterface;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Services\Employee\EmployeeInterface;
use App\Services\Employee\NonEmployeeInterface;
use App\Services\Employee\Employee;
use App\Services\Employee\Applicant;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            InternetServiceProviderInterface::class,
            'App\Services\InternetServiceProvider\\'.ucfirst(Request::capture()->segment(2))
        );
        $this->app->bind(EmployeeInterface::class, Employee::class);
        $this->app->bind(NonEmployeeInterface::class, Applicant::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
