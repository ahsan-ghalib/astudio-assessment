<?php

namespace App\Enums;

use App\Traits\ArrayableEnum;

enum AttributeTypeEnum: string
{
    use ArrayableEnum;

    case TEXT = 'text';
    case DATE = 'date';
    case SELECT = 'select';
    case NUMBER = 'number';
}
