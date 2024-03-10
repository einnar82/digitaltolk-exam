<?php

namespace DTApi\Services\Interfaces;

use Illuminate\Http\JsonResponse;

interface JobServiceInterface
{
    public function resendSMSNotifications(int $jobId): JsonResponse;

    public function resendNotifications(int $jobId): JsonResponse;
}
