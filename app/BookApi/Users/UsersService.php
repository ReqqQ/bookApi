<?php

namespace BookApi\Users;

use BookApi\Integrations\SmsApi\SmsService;
use Illuminate\Hashing\BcryptHasher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class UsersService
 * @package BookApi\Users
 */
class UsersService
{
    private const NOTHING_CHANGED_STATUS = 0;
    public array $requestData = [];
    private UsersDbRepository $usersDbRepository;
    private BcryptHasher $bcryptHasher;
    private SmsService $smsService;

    /**
     * UsersService constructor.
     * @param UsersDbRepository $usersDbRepository
     * @param BcryptHasher $bcryptHasher
     * @param SmsService $smsService
     */
    public function __construct(
        UsersDbRepository $usersDbRepository,
        BcryptHasher $bcryptHasher,
        SmsService $smsService
    ) {
        $this->bcryptHasher = $bcryptHasher;
        $this->usersDbRepository = $usersDbRepository;
        $this->smsService = $smsService;
    }

    /**
     *
     */
    public function createUser(): void
    {
        $status = $this->usersDbRepository->createNewUser($this->requestData);

        if ($status === self::NOTHING_CHANGED_STATUS) {
            throw new HttpException(Response::HTTP_NO_CONTENT);
        }
    }

    /**
     *
     */
    public function securePassword(): void
    {
        $this->requestData['password'] = $this->bcryptHasher->make($this->requestData['password']);
    }

    /**
     * @param array $requestData
     */
    public function setRequestData(array $requestData): void
    {
        $this->requestData = $requestData;
    }

    /**
     * @param int $userId
     * @return int
     */
    public function updateUser(int $userId): int
    {
        $this->checkRequestUpdateData();

        return $this->usersDbRepository->updateCurrentUser($this->requestData, $userId);
    }

    /**
     *
     */
    private function checkRequestUpdateData(): void
    {
        if ($this->isRequestDataEmpty()) {
            throw new HttpException(Response::HTTP_NO_CONTENT);
        }

        if ($this->requestHasMail()) {
            unset($this->requestData['email']);
        }

        if ($this->requestHasPassword()) {
            $this->securePassword();
        }
    }

    /**
     * @return bool
     */
    private function requestHasMail(): bool
    {
        return isset($this->requestData['email']);
    }

    /**
     * @return bool
     */
    private function requestHasPassword(): bool
    {
        return isset($this->requestData['password']);
    }

    /**
     * @param int $userId
     * @return int
     */
    public function deleteUser(int $userId): int
    {
        $this->isUserEmail($userId);
        $this->sendSms($userId);

        return $this->usersDbRepository->deleteUser($this->requestData['email'], $userId);
    }

    /**
     * @param int $userId
     */
    private function isUserEmail(int $userId): void
    {
        if (!$this->usersDbRepository->emailIsCorrect($this->requestData['email'], $userId)) {
            throw new HttpException(Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * @return bool
     */
    private function isRequestDataEmpty(): bool
    {
        return empty($this->requestData);
    }

    /**
     * @param $userId
     */
    public function sendSms($userId): void
    {
        $userTelephone = $this->usersDbRepository->getUser($userId)->first()->telephone;

        if (!empty($userTelephone)) {
            $this->smsService->sendSms($userTelephone);
        }
    }
}
