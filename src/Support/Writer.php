<?php


namespace Icodestuff\LaDocumenter\Support;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Icodestuff\LaDocumenter\Contracts\Writer as Contract;

class Writer implements Contract
{
    protected StringBlade $stringBlade;
    protected Filesystem $filesystem;

    /**
     * Writer constructor.
     * @param StringBlade $stringBlade
     * @param Filesystem $filesystem
     */
    public function __construct(StringBlade $stringBlade, Filesystem $filesystem)
    {
        $this->stringBlade = $stringBlade;
        $this->filesystem = $filesystem;
    }

    public function menu(Collection $namespaces)
    {
        $blade =  $this->filesystem->get(__DIR__ . '/../Stubs/menu.blade.php');
        $markdown = $this->stringBlade->render($blade, ['namespaces' => $namespaces]);
        $markdown = $this->replaceBraces($markdown);
        $fileName = resource_path(config('larecipe.docs.route') . DIRECTORY_SEPARATOR . config('larecipe.versions.default') . DIRECTORY_SEPARATOR . 'index.md');

        return $this->filesystem->put($fileName, $markdown);
    }

    /**
     * Create the endpoint pages
     *
     * @param Collection $routes
     * @param string $name
     * @return bool|int
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function page(Collection $routes, string $name)
    {
        $blade = $this->filesystem->get(__DIR__ . '/../Stubs/page.blade.php');
        $markdown = $this->stringBlade->render($blade, ['group' => $routes->group, 'routes' => $routes]);
        $markdown = $this->replaceQuotes($markdown);
        $path = resource_path(config('larecipe.docs.route') . DIRECTORY_SEPARATOR .config('larecipe.versions.default') . DIRECTORY_SEPARATOR . strtolower($name));
        $fileName = $path . DIRECTORY_SEPARATOR . str_replace(' ', '-', strtolower($routes->group->name)) .'.md';
        if(!$this->filesystem->isDirectory($path)) {
            $this->filesystem->makeDirectory($path);
        }

        return $this->filesystem->put($fileName, $markdown);
    }

    /**
     * Replace the escaped braces
     *
     * @param $markdown
     * @return string|string[]
     */
    private function replaceBraces($markdown)
    {
        $markdown = str_replace(array("&#123;"), '{', $markdown);
        return str_replace(array("&#125;"), '}', $markdown);
    }

    /**
     * Sometimes the json quotes aren't always escaped properly, so this replaces the &quot; in the markdown.
     *
     * @param $markdown
     * @return string|string[]
     */
    private function replaceQuotes($markdown)
    {
        return str_replace("&quot;", '"', $markdown);
    }
}