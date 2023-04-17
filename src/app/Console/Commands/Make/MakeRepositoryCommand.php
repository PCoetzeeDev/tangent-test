<?php

namespace App\Console\Commands\Make;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {domainName} {repoName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a repository inside a domain';

    /**
     * @var string
     */
    protected string $domainName;

    /**
     * @var string
     */
    protected string $repoName;

    const STUB = 'repository.stub';


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
     * @throws Exception
     */
    public function handle(): void
    {
        $this->domainName = ucfirst($this->argument('domainName'));
        $this->repoName = ucfirst($this->argument('repoName')) . 'Repository';

        $domainPath = config('app.domain_dir');
        $domainFullPath = $domainPath . '/' . $this->domainName;
        $fullRepoPath = $domainFullPath . '/' . $this->repoName . '.php';

        try {
            if (File::exists($fullRepoPath)) {
                throw new Exception('Repository file already exists');
            }

            File::ensureDirectoryExists($domainFullPath);

            $fileContent = file_get_contents(__DIR__ . '/../../../../stubs/' . self::STUB);
            foreach ($this->getStubVariables() as $variable => $replacement) {
                $fileContent = str_replace('{{ '.$variable.' }}' , $replacement, $fileContent);
            }

            if (File::put($fullRepoPath, $fileContent)) {
                $this->info('Created new Repository at ' . $fullRepoPath);
            } else {
                throw new Exception('Failed to create new Repository');
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());

            exit(1);
        }
    }

    /**
     * @return array
     * TODO: Create base Command with this function and others
     */
    private function getStubVariables() : array
    {
        return [
            'namespace' => app()->getNamespace() . 'Lib\\' . Str::studly($this->domainName),
            'class' => Str::studly($this->repoName),
        ];
    }
}
