<?php


namespace Icodestuff\LaDocumenter\Commands;


use Icodestuff\LaDocumenter\Annotation\LaDocumenterRoute;
use Icodestuff\LaDocumenter\LaDocumenter;
use Icodestuff\LaDocumenter\Support\StringBlade;
use Icodestuff\LaDocumenter\Support\Writer;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class GenerateDocumentationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ladocumenter:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API Documentation with LaDocumenter';

    protected LaDocumenter $laDocumenter;
    protected StringBlade $stringBlade;
    protected Writer $writer;

    /**
     * GenerateDocumentationCommand constructor.
     * @param LaDocumenter $laDocumenter
     * @param StringBlade $stringBlade
     * @param Writer $writer
     */
    public function __construct(LaDocumenter $laDocumenter, StringBlade $stringBlade, Writer $writer)
    {
        parent::__construct();

        $this->laDocumenter = $laDocumenter;
        $this->stringBlade = $stringBlade;
        $this->writer = $writer;
    }

    public function handle()
    {
        if (is_null(config('larecipe'))) {
            $this->error('Please install LaRecipe before continuing.');
            return 1;
        }

        $laDocumenterRoutes = $this->laDocumenter->getFilteredRoutes();

        $laDocumenterRoutes = $laDocumenterRoutes->map(function (LaDocumenterRoute $laDocumenterRoute){
            try {
                $message = sprintf(
                    '✅ Documented: %s::%s',
                    $laDocumenterRoute->class,
                    $laDocumenterRoute->classMethod
                );
                $laDocumenterRoute = $this->laDocumenter->getMethodDocBlock($laDocumenterRoute);
                $this->info($message);
                return $laDocumenterRoute;
            }catch (\Exception $exception) {
                $message = sprintf(
                    '❌ Skipped: %s::%s because %s',
                    $laDocumenterRoute->class,
                    $laDocumenterRoute->classMethod,
                    $exception->getMessage()
                );
                $this->info($message);
                return false;
            }
        })->reject(function ($value) {
            return $value === false;
        });

        $namespaces = $this->laDocumenter->groupEndpoints($laDocumenterRoutes);

        $namespaces = $namespaces->map(function ($namespace){
            $items = $namespace->all();
            ksort($items);
            return collect($items);
        });

        $this->writer->menu($namespaces);

        $namespaces->map(function (Collection $namespace, string $name){
            $namespace->map(function (Collection $endpoints) use ($name){

                $this->writer->page($endpoints, $name);
            });
        });

        return 0;
    }
}