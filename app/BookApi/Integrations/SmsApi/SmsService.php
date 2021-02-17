<?php

namespace BookApi\Integrations\SmsApi;

use BookApi\Interfaces\Integrations\SmsServiceInterface;
use Smsapi\Client\Curl\SmsapiHttpClient;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Service\SmsapiPlService;

/**
 * Class SmsService
 * @package BookApi\Integrations\SmsApi
 */
class SmsService implements SmsServiceInterface
{
    private const DELETE_MSG = 'Your account has been deleted.';
    private SmsapiHttpClient $smsapiHttpClient;

    /**
     * SmsService constructor.
     * @param SmsapiHttpClient $smsapiHttpClient
     */
    public function __construct(SmsapiHttpClient $smsapiHttpClient)
    {
        $this->smsapiHttpClient = $smsapiHttpClient;
    }

    /**
     * @param int $userTelephone
     */
    public function sendSms(int $userTelephone): void
    {
        $sms = $this->createMessage($userTelephone);
        $service = $this->setApiSmsToken();

        $service->smsFeature()->sendSms($sms);
    }

    /**
     * @param int $userTelephone
     * @return SendSmsBag
     */
    private function createMessage(int $userTelephone): SendSmsBag
    {
        return SendSmsBag::withMessage($userTelephone, self::DELETE_MSG);
    }

    /**
     * @return SmsapiPlService
     */
    private function setApiSmsToken(): SmsapiPlService
    {
        return $this->smsapiHttpClient->smsapiPlService(env('SMS_API_TOKEN'));
    }
}
