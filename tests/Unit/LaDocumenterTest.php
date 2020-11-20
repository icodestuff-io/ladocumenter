<?php


namespace Tests\Unit;


use Icodestuff\LaDocumenter\Annotation\Endpoint;
use Icodestuff\LaDocumenter\Annotation\Group;
use Icodestuff\LaDocumenter\Annotation\LaDocumenterRoute;
use Icodestuff\LaDocumenter\Exceptions\AnnotationException;
use Icodestuff\LaDocumenter\Exceptions\LaDocumenterException;
use Icodestuff\LaDocumenter\LaDocumenter;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class LaDocumenterTest extends TestCase
{
    /**
     * @var LaDocumenter|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $laDocumenter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->laDocumenter = \Mockery::mock(LaDocumenter::class);
    }

    /**
     * @covers ::getFilteredRoutes
     */
    public function testGetFilteredRoutes()
    {
        $collection = new Collection();
        $this->laDocumenter->shouldReceive('getFilteredRoutes')->andReturn($collection);
        $routes = $this->laDocumenter->getFilteredRoutes();
        $this->assertSame($collection, $routes);
    }

    /**
     * @covers ::getMethodDocBlock
     */
    public function testGetMethodDocBlock()
    {
        $laDocumenterRoute = new LaDocumenterRoute();
        $this->laDocumenter->shouldReceive('getMethodDocBlock')
            ->with($laDocumenterRoute)
            ->andReturn($laDocumenterRoute);

        $this->assertSame($laDocumenterRoute, $this->laDocumenter->getMethodDocBlock($laDocumenterRoute));
    }

    /**
     * @covers ::getMethodDocBlock
     */
    public function testThrowsDocumentationException()
    {
        $this->expectException(LaDocumenterException::class);
        $laDocumenterRoute = new LaDocumenterRoute();
        $this->laDocumenter->shouldReceive('getMethodDocBlock')
            ->with($laDocumenterRoute)
            ->andThrow(LaDocumenterException::class);

        $this->laDocumenter->getMethodDocBlock($laDocumenterRoute);
    }

    /**
     * @covers ::getClassDocBlocks
     */
    public function testGetClassDocBlocks()
    {
        $group = new Group();
        $this->laDocumenter->shouldReceive('getClassDocBlocks')
            ->with('foo')
            ->andReturn($group);

        $result = $this->laDocumenter->getClassDocBlocks('foo');
        $this->assertSame($group, $result);
    }

    /**
     * @covers ::groupEndpoints
     */
    public function testGroupEndpoints()
    {
        $collection = new Collection();

        $this->laDocumenter->shouldReceive('groupEndpoints')
            ->with($collection)
            ->andReturn($collection);

        $result = $this->laDocumenter->groupEndpoints($collection);

        $this->assertSame($collection, $result);
    }
}