<?php

namespace App\Enums;

use App\Traits\ArrayableEnum;

enum ProjectStatusEnum: string
{
    use ArrayableEnum;

    case PENDING = 'Pending';
    case IN_PROGRESS = 'In Progress';
    case COMPLETED = 'Completed';
    case ON_HOLD = 'On Hold';
    case CANCELLED = 'Cancelled';
}
