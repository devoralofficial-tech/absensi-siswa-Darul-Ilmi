<?php

namespace App\Providers;

use App\Repositories\AttendanceRepository;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Repositories\StudentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
    }
}
