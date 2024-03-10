<?php

namespace DTApi\Providers;

use DTApi\Repository\Interfaces\JobRepositoryInterface;
use DTApi\Repository\JobRepository;
use DTApi\Services\Interfaces\JobServiceInterface;
use DTApi\Services\Interfaces\NotificationServiceInterface;
use DTApi\Services\Interfaces\SmsServiceInterface;
use DTApi\Services\JobService;
use DTApi\Services\NotificationService;
use DTApi\Services\SmsService;
use Illuminate\Support\ServiceProvider;

class DTApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
        $this->app->bind(JobServiceInterface::class, JobService::class);
        $this->app->bind(SmsServiceInterface::class, SmsService::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
    }
}
