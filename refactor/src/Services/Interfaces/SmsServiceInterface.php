<?php

namespace DTApi\Services\Interfaces;

interface SmsServiceInterface
{
    public function sendSMSNotificationToTranslator($job): int;
}
