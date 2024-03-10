<?php

namespace DTApi\Services;

use DTApi\Repository\Interfaces\JobRepositoryInterface;
use DTApi\Services\Interfaces\JobServiceInterface;
use DTApi\Services\Interfaces\NotificationServiceInterface;
use DTApi\Services\Interfaces\SmsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JobService implements JobServiceInterface
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository,
        private readonly NotificationServiceInterface $notificationService,
        private readonly SmsServiceInterface $smsService,
    ){
    }

    public function resendSMSNotifications(int $jobId): JsonResponse
    {
        try {
            $job = $this->jobRepository->find($jobId);
            $this->jobRepository->jobToData($job);
            $this->smsService->sendSMSNotificationToTranslator($job);
            return \response()->json(['success' => 'SMS sent']);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function resendNotifications(int $jobId): JsonResponse
    {
        try {
            $job = $this->jobRepository->find($jobId);
            $job_data = $this->jobRepository->jobToData($job);
            $this->notificationService->sendNotificationTranslator($job, $job_data, '*');
            return \response()->json(['success' => 'Push sent']);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
