<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('scoreboard', function () {
    return true; // public channel - anyone can listen
});
