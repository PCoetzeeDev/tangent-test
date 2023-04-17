<?php

namespace App\Console\Commands\Make;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeEntityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:entity {domainName} {entityName} {--createFactory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a model entity inside a domain';

    /**
     * @var string
     */
    protected string $domainName;

    /**
     * @var string
     */
    protected string $entityName;

    protected bool $createFactory;

    const STUB = 'entity.stub';
    const FACTORY_STUB = 'factory.stub';


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
        $this->domainName = $this->argument('domainName');
        $this->entityName = $this->argument('entityName');
        $this->createFactory = $this->option('createFactory');

        $domainPath = config('app.domain_dir');
        $domainFullPath = $domainPath . '/' . $this->domainName;
        $fullEntityPath = $domainFullPath . '/' . $this->entityName . '.php';

        try {
            if (File::exists($fullEntityPath)) {
                throw new Exception('Entity file already exists');
            }

            File::ensureDirectoryExists($domainFullPath);

            $fileContent = file_get_contents(__DIR__ . '/../../../../stubs/' . self::STUB);
            foreach ($this->getStubVariables(self::STUB) as $variable => $replacement) {
                $fileContent = str_replace('{{ '.$variable.' }}' , $replacement, $fileContent);
            }

            if (File::put($fullEntityPath, $fileContent)) {
                $this->info('Created new entity at ' . $fullEntityPath);
            } else {
                throw new Exception('Failed to create new entity');
            }

            if ($this->createFactory === true) {
                $fileContent = file_get_contents(__DIR__ . '/../../../../stubs/' . self::FACTORY_STUB);
                foreach ($this->getStubVariables(self::FACTORY_STUB) as $variable => $replacement) {
                    $fileContent = str_replace('{{ '.$variable.' }}' , $replacement, $fileContent);
                }

                $factoryPath = $domainFullPath . '/' . Str::studly($this->entityName) . 'Factory.php';

                if (File::put($factoryPath, $fileContent)) {
                    $this->info('Created new Factory at ' . $factoryPath);
                } else {
                    throw new Exception('Failed to create new Factory');
                }
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());

            exit(1);
        }
    }

    /**
     * @param string $stub
     * @return array
     * @throws Exception
     */
    private function getStubVariables(string $stub) : array
    {
        switch ($stub) {
            case self::STUB:
                return [
                    'namespace'         => app()->getNamespace() . 'Lib\\' . Str::studly($this->domainName),
                    'class'             => Str::studly($this->entityName),
                    'table'             => Str::plural(Str::lower($this->entityName)),
                    'factory'           => $this->createFactory ? 'use Illuminate\Database\Eloquent\Factories\HasFactory;' : '',
                    'hasfactory'        => $this->createFactory ? 'use HasFactory;' : '',
                ];
            case self::FACTORY_STUB:
                return [
                    'namespace'         => app()->getNamespace() . 'Lib\\' . Str::studly($this->domainName),
                    'class'             => Str::studly($this->entityName),
                ];
        }

        throw new Exception("Unknown stub - " . $stub);
    }
}
