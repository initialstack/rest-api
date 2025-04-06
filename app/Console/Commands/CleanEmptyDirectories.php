<?php declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DirectoryCleaner;

final class CleanEmptyDirectories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'directories:clean {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean empty directories in specified path';

    /**
     * Execute the console command.
     *
     * @param \App\Services\DirectoryCleaner $cleaner
     * @return void
     */
    public function handle(DirectoryCleaner $cleaner): void
    {
        $directory = base_path(
            path: $this->option(key: 'path') ?? 'storage/app/public'
        );

        $cleaner->clean(directory: $directory);

        $this->info(
            string: 'Empty directories cleaned successfully!'
        );
    }
}
