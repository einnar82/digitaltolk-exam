<?php

namespace DTApi\Services\Interfaces;

interface NotificationServiceInterface
{
    public function sendNotificationTranslator($job, $data = [], $exclude_user_id): void;
}
