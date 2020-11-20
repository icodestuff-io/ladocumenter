<?php


namespace Icodestuff\LaDocumenter\Support;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\View\Factory as Viewer;
use Illuminate\View\Compilers\BladeCompiler;
use Icodestuff\LaDocumenter\Contracts\StringBlade as Contract;

class StringBlade implements Contract
{
    protected Filesystem $filesystem;
    protected Viewer $viewer;
    protected BladeCompiler $bladeCompiler;

    /**
     * StringBlade constructor.
     * @param Filesystem $filesystem
     * @param Viewer $viewer
     * @param BladeCompiler $bladeCompiler
     */
    public function __construct(Filesystem $filesystem, Viewer $viewer, BladeCompiler $bladeCompiler)
    {
        $this->filesystem = $filesystem;
        $this->viewer = $viewer;
        $this->bladeCompiler = $bladeCompiler;
    }


    /**
     * Get the rendered HTML.
     *
     * @param $bladeString
     * @param array $data
     * @return bool|string
     */
    public function render($bladeString, $data = [])
    {
        // Put the php version of blade String to *.php temp file & returns the temp file path
        $bladePath = $this->getBlade($bladeString);

        if (!$bladePath) {
            return false;
        }

        // Render the php temp file & return the HTML content
        $content = $this->viewer->file($bladePath, $data)->render();

        // Delete the php temp file.
        $this->filesystem->delete($bladePath);

        return $content;
    }

    /**
     * Get Blade File path.
     *
     * @param $bladeString
     * @return bool|string
     */
    protected function getBlade($bladeString)
    {
        $bladePath = $this->generateBladePath();

        $content = $this->bladeCompiler->compileString($bladeString);

        return $this->filesystem->put($bladePath, $content)
            ? $bladePath
            : false;
    }

    /**
     * Generate a blade file path.
     *
     * @return string
     */
    protected function generateBladePath()
    {
        $cachePath = rtrim(config('cache.stores.file.path'), '/');
        $tempFileName = sha1('string-blade' . microtime());
        $directory = "{$cachePath}/string-blades";

        if (!is_dir($directory)) {
            mkdir($directory, 0777);
        }

        return "{$directory}/{$tempFileName}.php";
    }
}