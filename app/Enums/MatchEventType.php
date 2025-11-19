<?php

namespace App\Enums;

enum MatchEventType: string
{
    case GOAL = "goal";
    case FOUL = "foul";
    case YELLOW_CARD = "yellow_card";
    case RED_CARD = "red_card";
    case OFFSIDE = "offside";
    case SHOT = "shot";
    case HALFTIME = "halftime";
    case MATCH_END = "match_end";
    case SWAP_SIDE = "swap_side";
}
