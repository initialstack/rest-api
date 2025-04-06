<?php declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Scans a directory for files matching specific patterns and returns their fully qualified class names.
 *
 * This function is used to automatically discover and register controllers or other classes based on file names.
 *
 * @param string $path
 * @param string $namespace
 * @param array $patterns
 * 
 * @return array
 */
if (!function_exists(function: 'scan')) {
    function scan(string $path, string $namespace, array $patterns = []): array
    {
        $controllers = [];

        foreach (scandir(directory: $path) as $file) {
            if (is_file(filename: $path . '/' . $file)) {
                foreach ($patterns as $pattern) {
                    $isFullMatch = preg_match(
                        pattern: '/' . preg_quote(str: $pattern, delimiter: '/') . '$/',
                        subject: $file
                    );

                    if ($isFullMatch) {
                        $controllers[] = $namespace . '\\' . substr(
                            string: $file, offset: 0, length: -4
                        );
                        break;
                    }
                }
            }

            if (is_dir(filename: $path . '/' . $file) && $file !== '.' && $file !== '..') {
                $subNamespace = $namespace . '\\' . $file;

                $controllers = [...$controllers, ...scan(
                    path: $path . '/' . $file,
                    namespace: $subNamespace,
                    patterns: $patterns
                )];
            }
        }

        return $controllers;
    }
}
