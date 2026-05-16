<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bootstrap-safe handler — zero filesystem calls, zero helpers.
 * Returns the FULL reflection stack directly as the HTTP body.
 */
class AppExceptionHandler
{
    public function render($request, Throwable $e): Response
    {
        // Log to PHP internal error_log (no filesystem path)
        if (function_exists('error_log')) {
            @error_log('LARAVEL-FATAL: '.$e->getMessage());
        }

        // Build body deterministically without calling any container helpers
        $body  = "HTTP/1.1 500 Internal Server Error\n\n";
        $body .= "CLASS:    " . $e::class . "\n";
        $body .= "MESSAGE:  " . $e->getMessage() . "\n";
        $body .= "FILE:     " . $e->getFile() . ":" . $e->getLine() . "\n\n";

        $trace = $e->getTrace();
        $body .= "TRACE (" . count($trace) . " frames):\n";
        foreach ($trace as $i => $frame) {
            $body .= sprintf(
                "  #%-3d %s%s%s:%d\n",
                $i,
                $frame['class'] ?? '',
                $frame['type'] ?? '',
                $frame['function'],
                $frame['line'] ?? 0
            );
        }
        $body .= "\n--- PREVIOUS ---\n";
        $prev = $e->getPrevious();
        if ($prev) {
            $body .= $prev::class . ": " . $prev->getMessage() . "\n";
            $body .= "  " . $prev->getFile() . ":" . $prev->getLine() . "\n";
        }

        return new Response($body, 500, ['Content-Type' => 'text/plain']);
    }

    public function renderForConsole($output, Throwable $e): void
    {
        @error_log("FATAL-CONSOLE: " . $e->getMessage());
    }

    public function report(Throwable $e): void
    {
        @error_log("LARAVEL-REPORT: " . $e->getMessage());
    }

    public function shouldReport(Throwable $e): bool { return false; }
    public function getPreviousHandler(): ?\Illuminate\Contracts\Debug\ExceptionHandlerContract { return null; }
    public function setPreviousHandler(\Illuminate\Contracts\Debug\ExceptionHandlerContract $previous): void {}
}
