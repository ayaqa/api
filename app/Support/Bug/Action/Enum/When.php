<?php

namespace AyaQA\Support\Bug\Action\Enum;

enum When
{
    case REQUEST_START;
    case BEFORE_SAVE;
    case BEFORE_DATA_VALIDATION;
    case AFTER_DATA_VALIDATION;
    case AFTER_SAVE;
    case REQUEST_END;
}
