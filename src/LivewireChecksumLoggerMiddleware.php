<?php

namespace LivewireChecksumLogger;

class LivewireChecksumLoggerMiddleware
{
    public function handle($request, $next)
    {
        LivewireChecksumLogger::logRequest($request);

        return $next($request);
    }
}
