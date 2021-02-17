<?php

namespace BookApi\Interfaces\Integrations;

interface SmsServiceInterface
{
    public function sendSms(int $userTelephone): void;
}
