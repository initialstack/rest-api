<?php declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\File;

final class DirectoryCleaner
{
    /**
     * Recursively clean empty directories.
     *
     * @param string $directory
     * @return void
     */
    public function clean(string $directory): void
    {
        $directories = File::directories(
            directory: $directory
        );

        foreach ($directories as $dir) {
            $files = File::files(directory: $dir);

            if (empty($files)) {
                File::deleteDirectory(directory: $dir);
            } else {
                $this->clean(directory: $dir);
            }
        }
    }
}
