<?php


namespace Icodestuff\LaDocumenter;


use Icodestuff\LaDocumenter\Commands\GenerateDocumentationCommand;
use Illuminate\Support\ServiceProvider;
use Minime\Annotations\Cache\ArrayCache;
use Minime\Annotations\Interfaces\ReaderInterface;
use Minime\Annotations\Parser;

class LaDocumenterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/ladocumenter.php' => config_path('ladocumenter.php')], 'ladocumenter');

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateDocumentationCommand::class
            ]);
        }

        $this->app->bind(ReaderInterface::class, function (){
            return new \Minime\Annotations\Reader(
                $this->app->make(Parser::class),
                $this->app->make( ArrayCache::class)
            );
        });

        $this->app->bind(
            \Icodestuff\LaDocumenter\Contracts\Extractor::class,
            \Icodestuff\LaDocumenter\Support\Extractor::class
        );

        $this->app->bind(
            \Icodestuff\LaDocumenter\Contracts\LaDocumenter::class,
            \Icodestuff\LaDocumenter\LaDocumenter::class
        );

        $this->app->bind(
            \Icodestuff\LaDocumenter\Contracts\StringBlade::class,
            \Icodestuff\LaDocumenter\Support\StringBlade::class
        );


    }
}