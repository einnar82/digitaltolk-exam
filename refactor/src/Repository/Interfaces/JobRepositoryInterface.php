<?php

namespace DTApi\Repository\Interfaces;

use DTApi\Models\Job;
use Illuminate\Http\Request;

interface JobRepositoryInterface
{
    public function getUsersJobs($user_id): array;

    /**
     * @param $user_id
     * @return array
     */
    public function getUsersJobsHistory($user_id, Request $request);

    /**
     * @param $user
     * @param $data
     * @return mixed
     */
    public function store($user, $data);

    /**
     * @param $data
     * @return mixed
     */
    public function storeJobEmail($data);

    /**
     * @param $job
     * @return array
     */
    public function jobToData($job);

    /**
     * @param array $post_data
     */
    public function jobEnd($post_data = array());

    /**
     * Function to get all Potential jobs of user with his ID
     * @param $user_id
     * @return array
     */
    public function getPotentialJobIdsWithUserId($user_id);


    /**
     * @param Job $job
     * @return mixed
     */
    public function getPotentialTranslators(Job $job);

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateJob($id, $data, $cuser);

    public function sendSessionStartRemindNotification($user, $job, $language, $due, $duration);

    /**
     * @param $job
     * @param $current_translator
     * @param $new_translator
     */
    public function sendChangedTranslatorNotification($job, $current_translator, $new_translator);

    /**
     * @param $job
     * @param $old_time
     */
    public function sendChangedDateNotification($job, $old_time);

    /**
     * @param $job
     * @param $old_lang
     */
    public function sendChangedLangNotification($job, $old_lang);

    /**
     * Function to send Job Expired Push Notification
     * @param $job
     * @param $user
     */
    public function sendExpiredNotification($job, $user);

    /**
     * Function to send the notification for sending the admin job cancel
     * @param $job_id
     */
    public function sendNotificationByAdminCancelJob($job_id);

    /**
     * @param $data
     * @param $user
     */
    public function acceptJob($data, $user);

    public function acceptJobWithId($job_id, $cuser);

    public function cancelJobAjax($data, $user);

    public function getPotentialJobs($cuser);

    public function endJob($post_data);

    public function markCustomerAsNotCalled($post_data);

    public function getAll(Request $request, $limit = null);

    public function alerts();

    public function userLoginFailed();

    public function bookingExpireNoAccepted();

    public function ignoreExpiring($id);

    public function ignoreExpired($id);

    public function ignoreThrottle($id);

    public function reopen(int $jobId);

    public function updateDistanceFeed(array $data): bool;
}
