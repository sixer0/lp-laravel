<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpFoundation\Response;

class AppExceptionHandler implements \Illuminate\Contracts\Debug\ExceptionHandler
{
    public function render($request, Throwable $e): Response
    {
        @error_log('LARAVEL-FATAL: ' . $e->getMessage());

        $trace = '';
        foreach ($e->getTrace() as $i => $frame) {
            $trace .= sprintf(
                "#%-3d %s%s%s:%d\n",
                $i, $frame['class'] ?? '', $frame['type'] ?? '', $frame['function'] ?? '?', $frame['line'] ?? 0
            );
        }

        $body  = "CLASS: " . $e::class . "\n";
        $body .= "MSG:   " . $e->getMessage() . "\n";
        $body .= "FILE:  " . $e->getFile() . ':' . $e->getLine() . "\n\n";
        $body .= "TRACE:\n" . $trace;

        file_put_contents(base_path('storage/logs/laravel_error_trace.txt'), $body . "\n" . date('c'), FILE_APPEND);

        return new Response($body, 500, ['Content-Type' => 'text/plain']);
    }

    public function renderForConsole($output, Throwable $e): void {}
    public function report(Throwable $e): void {}
    public function shouldReport(Throwable $e): bool { return false; }
    public function getPreviousHandler(): ?\Illuminate\Contracts\Debug\ExceptionHandlerContract { return null; }
    public function setPreviousHandler(\Illuminate\Contracts\Debug\ExceptionHandlerContract $previous): void {}
}
