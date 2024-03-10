<?php

namespace DTApi\Http\Controllers;

use DTApi\Http\Requests\AcceptJobRequest;
use DTApi\Http\Requests\CancelJobRequest;
use DTApi\Http\Requests\CreateJobRequest;
use DTApi\Http\Requests\EndJobRequest;
use DTApi\Http\Requests\MarkCustomerAsNotCalledRequest;
use DTApi\Http\Requests\UpdateDistanceFeedRequest;
use DTApi\Http\Requests\UpdateJobRequest;
use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use DTApi\Repository\Interfaces\JobRepositoryInterface;
use DTApi\Services\Interfaces\JobServiceInterface;
use DTApi\Services\Interfaces\NotificationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class JobController extends Controller
{
    public function __construct(
        private readonly JobRepositoryInterface $jobRepository,
        private readonly JobServiceInterface $jobService,
    ){
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();

            if ($user->user_type !== config('app.admin_role_id') || $user->user_type !== config('app.superadmin_role_id')) {
                $response = $this->jobRepository->getUsersJobs($user->getAuthIdentifier());
                \response()->json($response);
            }

            $response = $this->jobRepository->getAll($request);
            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(int $id): JsonResponse
    {
        $job = $this->jobRepository->with('translatorJobRel.user')->find($id);

        if ($job === null) {
            return \response()->json([
                'message' => 'Not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return \response()->json([
            'job' => $job
        ]);
    }

    public function store(CreateJobRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = auth()->user();
            $response = $this->jobRepository->store($user, $data);

            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function update(int $id, UpdateJobRequest $request): JsonResponse
    {
        try {
            $data = $request->all();
            $user = auth()->user();
            $response = $this->jobRepository->updateJob($id, Arr::except($data, ['_token', 'submit']), $user);

            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function immediateJobEmail(CreateJobRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $response = $this->jobRepository->storeJobEmail($data);

            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getHistory(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $response = $this->jobRepository->getUsersJobsHistory($user->getAuthIdentifier(), $request);
            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function acceptJob(AcceptJobRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = $request->user();

            $response = $this->jobRepository->acceptJob($data, $user);

            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cancelJob(CancelJobRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = $request->user();

            $response = $this->jobRepository->cancelJobAjax($data, $user);

            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function endJob(EndJobRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $response = $this->jobRepository->endJob($data);

            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function markCustomerAsNotCalled(MarkCustomerAsNotCalledRequest $request): JsonResponse
    {
        try {
            $data = $request->all();

            $response = $this->jobRepository->markCustomerAsNotCalled($data);

            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getPotentialJobs(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $response = $this->jobRepository->getPotentialJobs($user);

            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function distanceFeed(UpdateDistanceFeedRequest $request): JsonResponse
    {
        $isDistanceFeedUpdated =$this->jobRepository->updateDistanceFeed($request->validated());

        if ($isDistanceFeedUpdated) {
            return \response()->json([
                'message' => 'Record updated!'
            ]);
        }
        return \response()->json([
            'message' => 'Something went wrong',
        ], Response::HTTP_BAD_REQUEST);
    }

    public function reopen(int $jobId): JsonResponse
    {
        try {
            $response = $this->jobRepository->reopen($jobId);

            return \response()->json($response);
        } catch (\Throwable $exception) {
            return \response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function resendNotifications(int $jobId): JsonResponse
    {
        return $this->jobService->resendSMSNotifications($jobId);
    }

    public function resendSMSNotifications(int $jobId): JsonResponse
    {
        return $this->jobService->resendSMSNotifications($jobId);
    }
}
