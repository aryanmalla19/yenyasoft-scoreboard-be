<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Log;

function safe_broadcast($event): void
{
    try {
        broadcast($event);
    } catch (\Throwable $e) {
        Log::warning("Broadcast failed: " . $e->getMessage());
    }
}
