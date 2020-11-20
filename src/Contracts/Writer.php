<?php


namespace Icodestuff\LaDocumenter\Contracts;


use Illuminate\Support\Collection;

interface Writer
{
    /**
     * Create the documentation menu
     *
     * @param Collection $namespaces
     * @return bool|int
     */
    public function menu(Collection $namespaces);

    /**
     * Create the endpoint pages
     *
     * @param Collection $routes
     * @param string $name
     * @return bool|int
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function page(Collection $routes, string $name);
}