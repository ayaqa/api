<?php

namespace AyaQA\Support\BugFramework\Bug\Enum;

enum ParamType
{
    case GET;
    case POST;
    case HEADER;
    case RESPONSE;
}
