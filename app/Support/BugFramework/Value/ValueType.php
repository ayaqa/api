<?php

namespace AyaQA\Support\BugFramework\Value;

use AyaQA\Support\BugFramework\Support\Contract\HasId;
use AyaQA\Support\BugFramework\Value\Collection\GetParams;
use AyaQA\Support\BugFramework\Value\Collection\HeaderParams;
use AyaQA\Support\BugFramework\Value\Collection\Params;
use AyaQA\Support\BugFramework\Value\Collection\PostParams;
use AyaQA\Support\BugFramework\Value\Custom\AppStepValue;
use Throwable;

enum ValueType: string implements HasId
{
    case HEADER_PARAM = 'header_param';
    case GET_PARAM = 'get_param';
    case POST_PARAM = 'post_param';
    case PARAM = 'param';
    case CLIENT_IP = 'client_ip';
    case REQUEST_TYPE = 'request_type';
    case SECTION_ID = 'section_id';
    case RESPONSE_PARAM = 'response_param';
    case APP_STEP = 'app_step';

    public function getFieldClass(): string
    {
        return match ($this) {
            self::HEADER_PARAM => HeaderParamValue::class,
            self::GET_PARAM => GetParamValue::class,
            self::POST_PARAM => PostParamValue::class,
            self::PARAM, self::RESPONSE_PARAM => ParamValue::class,
            self::CLIENT_IP => ClientIpValue::class,
            self::REQUEST_TYPE => RequestType::class,
            self::SECTION_ID => SectionId::class,
            self::APP_STEP => AppStepValue::class
        };
    }

    public function getCollectionClass(): string
    {
        return match ($this) {
            self::HEADER_PARAM => HeaderParams::class,
            self::GET_PARAM => GetParams::class,
            self::POST_PARAM => PostParams::class,
            self::PARAM, self::RESPONSE_PARAM => Params::class,
            default => throw new \RuntimeException(
                sprintf('Bug value %s dont have collection or is not mapped', $this->name)
            )
        };
    }

    public function hasCollection(): bool
    {
        try {
            self::getCollectionClass();

            return true;
        } catch (Throwable) {
        }

        return false;
    }

    public function getId(): string
    {
        return $this->value;
    }
}
