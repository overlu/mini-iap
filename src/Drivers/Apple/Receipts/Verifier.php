<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Receipts;

use MiniIap\Drivers\Apple\ClientFactory;
use MiniIap\Drivers\Apple\Exceptions\InvalidReceiptException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Verifier
 * @see https://developer.apple.com/documentation/appstorereceipts/verifyreceipt
 * @package MiniIap\Drivers\Apple\Receipts
 */
class Verifier
{
    public const TEST_ENV_CODE = 21007;

    public const VERIFY_RECEIPT_PATH = '/verifyReceipt';

    /**
     * @var ClientInterface
     */
    protected ClientInterface $client;

    /**
     * @var string
     */
    protected string $receiptData;

    /**
     * @var string
     */
    protected string $password;

    /**
     * Receipt constructor.
     *
     * @param ClientInterface $client
     * @param string $receiptData
     * @param string $password
     */
    public function __construct(ClientInterface $client, string $receiptData, string $password)
    {
        $this->client = $client;
        $this->receiptData = $receiptData;
        $this->password = $password;
    }

    /**
     * @param ClientInterface|null $sandboxClient
     * @return ReceiptResponse
     * @throws GuzzleException
     * @throws InvalidReceiptException
     */
    public function verifyRenewable(?ClientInterface $sandboxClient = null): ReceiptResponse
    {
        return $this->verify(true, $sandboxClient);
    }

    /**
     * @param bool $excludeOldTransactions
     * @param ClientInterface|null $sandboxClient
     * @return ReceiptResponse
     * @throws GuzzleException
     * @throws InvalidReceiptException
     */
    public function verify(bool $excludeOldTransactions = false, ?ClientInterface $sandboxClient = null): ReceiptResponse
    {
        $responseBody = $this->sendVerifyRequest($excludeOldTransactions);

        $status = $responseBody['status'];

        if ($this->isInvalidReceiptStatus($status)) {
            throw InvalidReceiptException::create($status);
        }

        if ($this->isFromTestEnv($status)) {
            $responseBody = $this->sendVerifyRequest($excludeOldTransactions, $sandboxClient ?? ClientFactory::createSandbox());
        }

        return ReceiptResponse::fromArray($responseBody);
    }

    /**
     * @param bool $excludeOldTransactions
     * @param ClientInterface|null $client
     * @return array
     * @throws GuzzleException
     */
    private function sendVerifyRequest(bool $excludeOldTransactions = false, ?ClientInterface $client = null): array
    {
        $client = $client ?? $this->client;
        $options = $this->buildRequestOptions($excludeOldTransactions);
        $response = $client->post(self::VERIFY_RECEIPT_PATH, $options);

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @param bool $excludeOldTransactions
     * @return array[]
     */
    private function buildRequestOptions(bool $excludeOldTransactions): array
    {
        return [
            'json' => [
                'receipt-data' => $this->receiptData,
                'password' => $this->password,
                'exclude-old-transactions' => $excludeOldTransactions,
            ],
        ];
    }

    /**
     * @param int $status
     *
     * @return bool
     */
    private function isInvalidReceiptStatus(int $status): bool
    {
        if ($status === self::TEST_ENV_CODE) {
            return false;
        }

        return array_key_exists($status, InvalidReceiptException::ERROR_STATUS_MAP);
    }

    /**
     * @param int $status
     *
     * @return bool
     */
    private function isFromTestEnv(int $status): bool
    {
        return $status === self::TEST_ENV_CODE;
    }
}
