<?php

declare(strict_types=1);

$betterphp_debug_helper_reserved_memory = \str_repeat("x", 1024);

\set_exception_handler(
    function (\Throwable $exception) {
        unset($GLOBALS["betterphp_debug_helper_reserved_memory"]);

        // TODO: Do all the stuff
    }
);

\set_error_handler(
    function (int $errno, string $message, string $file, int $line, array $context) {
        throw new \ErrorException(
            code: $errno,
            message: $message,
            file: $file,
            line: $line,
        );
    }
);

\register_shutdown_function(
    function () {
        $last_error = \error_get_last();

        if ($last_error !== null) {
            throw new \ErrorException(
                code: $last_error["type"],
                message: $last_error["message"],
                file: $last_error["file"],
                line: $last_error["line"],
            );
        }
    }
);
