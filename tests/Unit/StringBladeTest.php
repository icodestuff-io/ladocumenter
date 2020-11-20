<?php


namespace Tests\Unit;


use Icodestuff\LaDocumenter\Support\StringBlade;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Icodestuff\LaDocumenter\Support\StringBlade
 */
class StringBladeTest extends TestCase
{
    /**
     * @var StringBlade|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $stringBlade;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stringBlade = \Mockery::mock(StringBlade::class);
    }

    /**
     * @covers ::render
     */
    public function testRender()
    {
        $this->stringBlade->shouldReceive('render')
            ->with('foo', ['a' => 'b'])
            ->andReturn('bar');

        $result = $this->stringBlade->render('foo', ['a' => 'b']);

        $this->assertSame('bar', $result);
    }
}