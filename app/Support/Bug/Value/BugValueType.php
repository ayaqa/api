<?php

namespace AyaQA\Support\Bug\Value;

use AyaQA\Support\Bug\Value\Collection\BugGetParams;
use AyaQA\Support\Bug\Value\Collection\BugHeaderParams;
use AyaQA\Support\Bug\Value\Collection\BugParams;
use AyaQA\Support\Bug\Value\Collection\BugPostParams;
use Throwable;

enum BugValueType: string
{
    case HEADER_PARAM = 'header_param';
    case GET_PARAM = 'get_param';
    case POST_PARAM = 'post_param';
    case PARAM = 'param';
    case CLIENT_IP = 'client_ip';
    case REQUEST_TYPE = 'request_type';
    case SECTION_ID = 'section_id';
    case RESPONSE_PARAM = 'response_param';

    public function getFieldClass(): string
    {
        return match ($this) {
            self::HEADER_PARAM => BugHeaderParam::class,
            self::GET_PARAM => BugGetParam::class,
            self::POST_PARAM => BugPostParam::class,
            self::PARAM, self::RESPONSE_PARAM => BugParam::class,
            self::CLIENT_IP => BugClientIp::class,
            self::REQUEST_TYPE => BugRequestType::class,
            self::SECTION_ID => BugSectionId::class,
        };
    }

    public function getCollectionClass(): string
    {
        return match ($this) {
            self::HEADER_PARAM => BugHeaderParams::class,
            self::GET_PARAM => BugGetParams::class,
            self::POST_PARAM => BugPostParams::class,
            self::PARAM, self::RESPONSE_PARAM => BugParams::class,
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

    public function asString(): string
    {
        return $this->value;
    }
}
