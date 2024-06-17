<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\ValueObjects;

/**
 * Class Status
 * @package App\Payment\Apple\ValueObjects
 */
final class Status
{
    public const STATUS_VALID = 0;

    public const STATUS_REQUEST_METHOD_NOT_POST = 21000;
    public const STATUS_STATUS_CODE_NOT_SENT = 21001;
    public const STATUS_RECEIPT_DATA_MALFORMED = 21002;
    public const STATUS_COULD_NOT_BE_AUTHENTICATED = 21003;
    public const STATUS_INVALID_SHARED_SECRET = 21004;
    public const STATUS_SERVER_UNAVAILABLE = 21005;
    public const STATUS_SUBSCRIPTION_EXPIRED = 21006;
    public const STATUS_FROM_TEST_ENV = 21007;
    public const STATUS_FROM_PRODUCTION_ENV = 21008;
    public const STATUS_INTERNAL_DATA_ACCESS_ERROR_21009 = 21009;
    public const STATUS_ACCOUNT_NOT_FOUND = 21010;
    public const STATUS_INTERNAL_DATA_ACCESS_ERROR_21100 = 21100;
    public const STATUS_INTERNAL_DATA_ACCESS_ERROR_21199 = 21199;

    public const ERROR_STATUS_MAP = [
//        self::STATUS_REQUEST_METHOD_NOT_POST => '未使用HTTP POST请求方法向App Store发送请求',
//        self::STATUS_STATUS_CODE_NOT_SENT => '此状态代码不再由App Store发送',
//        self::STATUS_RECEIPT_DATA_MALFORMED => 'receipt-data属性中的数据格式错误或丢失',
//        self::STATUS_COULD_NOT_BE_AUTHENTICATED => '收据无法认证',
//        self::STATUS_INVALID_SHARED_SECRET => '您提供的共享密码与您帐户的文件共享密码不匹配',
//        self::STATUS_SERVER_UNAVAILABLE => '收据服务器当前不可用',
//        self::STATUS_SUBSCRIPTION_EXPIRED => '该收据有效，但订阅已过期',
//        self::STATUS_FROM_TEST_ENV => '该收据来自测试环境，但已发送到生产环境以进行验证',
//        self::STATUS_FROM_PRODUCTION_ENV => '该收据来自生产环境，但是已发送到测试环境以进行验证',
//        self::STATUS_INTERNAL_DATA_ACCESS_ERROR_21009 => '内部数据访问错误。稍后再试',
//        self::STATUS_ACCOUNT_NOT_FOUND => '找不到或删除了该用户帐户',
//        self::STATUS_INTERNAL_DATA_ACCESS_ERROR_21100 => '内部数据访问错误',
//        self::STATUS_INTERNAL_DATA_ACCESS_ERROR_21199 => '内部数据访问错误',

        self::STATUS_REQUEST_METHOD_NOT_POST => 'The request to the App Store was not made using the HTTP POST request method.',
        self::STATUS_STATUS_CODE_NOT_SENT => 'This status code is no longer sent by the App Store.',
        self::STATUS_RECEIPT_DATA_MALFORMED => 'The data in the receipt-data property was malformed or the service experienced a temporary issue.',
        self::STATUS_COULD_NOT_BE_AUTHENTICATED => 'The receipt could not be authenticated.',
        self::STATUS_INVALID_SHARED_SECRET => 'The shared secret you provided does not match the shared secret on file for your account.',
        self::STATUS_SERVER_UNAVAILABLE => 'The receipt server was temporarily unable to provide the receipt.',
        self::STATUS_SUBSCRIPTION_EXPIRED => 'This receipt is valid but the subscription has expired. When this status code is returned to your server, the receipt data is also decoded and returned as part of the response. Only returned for iOS 6-style transaction receipts for auto-renewable subscriptions.',
        self::STATUS_FROM_TEST_ENV => 'This receipt is from the test environment, but it was sent to the production environment for verification.',
        self::STATUS_FROM_PRODUCTION_ENV => 'This receipt is from the production environment, but it was sent to the test environment for verification.',
        self::STATUS_INTERNAL_DATA_ACCESS_ERROR_21009 => 'Internal data access error.',
        self::STATUS_ACCOUNT_NOT_FOUND => 'The user account cannot be found or has been deleted.',
        self::STATUS_INTERNAL_DATA_ACCESS_ERROR_21100 => 'Internal data access errors.',
        self::STATUS_INTERNAL_DATA_ACCESS_ERROR_21199 => 'Internal data access errors.',
    ];

    /**
     * @var int
     */
    private int $value;

    /**
     * Status constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return
            $this->value === self::STATUS_VALID;
//            || $this->value === self::STATUS_SUBSCRIPTION_EXPIRED;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
