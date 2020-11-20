<?php


namespace Tests\Unit;


use Icodestuff\LaDocumenter\Support\Writer;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Icodestuff\LaDocumenter\Support\Writer
 */
class WriterTest extends TestCase
{
    /**
     * @var Writer|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $writer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->writer = \Mockery::mock(Writer::class);
    }

    /**
     * @covers ::menu
     */
    public function testGenerateMenu()
    {
        $namespaces = new Collection();

        $this->writer->shouldReceive('menu')->with($namespaces)->andReturn(true);

        $this->assertTrue($this->writer->menu($namespaces));
    }

    /**
     * @covers ::page
     */
    public function testGeneratePage()
    {
        $endpoints = new Collection();

        $this->writer->shouldReceive('page')->with($endpoints, 'foo')->andReturn(true);

        $this->assertTrue($this->writer->page($endpoints, 'foo'));
    }
}