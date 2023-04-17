<?php

namespace App\Console\Commands\Make;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeValueObjectCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vo {domainName} {voName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a value object inside a domain';

    /**
     * @var string
     */
    protected string $domainName;

    /**
     * @var string
     */
    protected string $voName;

    const STUB = 'valueobject.stub';


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
        $this->voName = $this->argument('voName');

        $domainPath = config('app.domain_dir');
        $domainFullPath = $domainPath . '/' . $this->domainName;
        $fullVOPath = $domainFullPath . '/' . $this->voName . '.php';

        try {
            if (File::exists($fullVOPath)) {
                throw new Exception('VO file already exists');
            }

            File::ensureDirectoryExists($domainFullPath);

            $fileContent = file_get_contents(__DIR__ . '/../../../../stubs/' . self::STUB);
            foreach ($this->getStubVariables() as $variable => $replacement) {
                $fileContent = str_replace('{{ '.$variable.' }}' , $replacement, $fileContent);
            }

            if (File::put($fullVOPath, $fileContent)) {
                $this->info('Created new VO at ' . $fullVOPath);
            } else {
                throw new Exception('Failed to create new VO');
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
            'class' => Str::studly($this->voName),
            'table' => Str::snake(Str::plural(Str::lower(implode(' ', Str::ucsplit($this->voName))))),
        ];
    }
}
