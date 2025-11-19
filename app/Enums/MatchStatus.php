<?php

namespace App\Enums;

enum MatchStatus: string
{
    case NOT_STARTED = "not_started";
    case LIVE = "live";
    case HALFTIME = "halftime";
    case FINISHED = "finished";
}
