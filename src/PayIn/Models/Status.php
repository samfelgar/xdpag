<?php

declare(strict_types=1);

namespace Samfelgar\XdPag\PayIn\Models;

enum Status: string
{
    case Created = 'CREATED';
    case Processing = 'PROCESSING';
    case Finished = 'FINISHED';
    case Cancelled = 'CANCELLED';
    case Reversed = 'REVERSED';
    case Timeout = 'TIMEOUT';
}
