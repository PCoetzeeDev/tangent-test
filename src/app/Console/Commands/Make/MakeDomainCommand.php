<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDomainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain {domainName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a directory for a new domain in the correct folder';

    /**
     * @var string
     */
    protected string $domainName;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle(): void
    {
        $this->domainName = $this->argument('domainName');
        $domainPath = config('app.domain_dir');
        $fullPath = $domainPath . '/' . $this->domainName;

        try {
            if (File::isDirectory($fullPath)) {
                throw new \Exception('Path to domain already exists');
            }

            if (File::makeDirectory($fullPath)) {
                $this->info('Created new domain for ' . $this->domainName . ' at ' . $fullPath);
            } else {
                throw new \Exception('Failed to create new domain');
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());

            exit(1);
        }
    }
}
