<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayOut\Models;

enum Status: string
{
    case Created = 'CREATED';
    case Processing = 'PROCESSING';
    case Finished = 'FINISHED';
    case Cancelled = 'CANCELLED';
    case Reversed = 'REVERSED';
    case PartiallyReversed = 'PARTIALLY_REVERSED';
    case Timeout = 'TIMEOUT';
}
