<?php


namespace Tests\Unit;


use Icodestuff\LaDocumenter\Annotation\BodyParam;
use Icodestuff\LaDocumenter\Annotation\Endpoint;
use Icodestuff\LaDocumenter\Annotation\Group;
use Icodestuff\LaDocumenter\Annotation\QueryParam;
use Icodestuff\LaDocumenter\Annotation\ResponseExample;
use Icodestuff\LaDocumenter\Support\Extractor;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Icodestuff\LaDocumenter\Support\Extractor
 */
class ExtractorTest extends TestCase
{
    /**
     * @var Extractor|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    protected $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = \Mockery::mock(Extractor::class);
    }

    /**
     * @covers ::response
     */
    public function testResponse()
    {
        $responseExample = new ResponseExample();
        $this->extractor->shouldReceive('response')
            ->with('foo')
            ->andReturn($responseExample);

        $result = $this->extractor->response('foo');

        $this->assertSame($responseExample, $result);
    }

    /**
     * @covers ::endpoint
     */
    public function testEndpoint()
    {
        $endpoint = new Endpoint();
        $this->extractor->shouldReceive('endpoint')
            ->with('foo')
            ->andReturn($endpoint);

        $result = $this->extractor->endpoint('foo');

        $this->assertSame($endpoint, $result);
    }

    /**
     * @covers ::group
     */
    public function testGroup()
    {
        $group = new Group();

        $this->extractor->shouldReceive('group')->with('foo')->andReturn($group);

        $result = $this->extractor->group('foo');

        $this->assertSame($group, $result);
    }

    /**
     * @covers ::body
     */
    public function testBody()
    {
        $body = new BodyParam();

        $this->extractor->shouldReceive('body')->with('foo')->andReturn($body);

        $result = $this->extractor->body('foo');

        $this->assertSame($body, $result);
    }

    /**
     * @covers ::query
     */
    public function testQuery()
    {
        $query = new QueryParam();

        $this->extractor->shouldReceive('query')->with('foo')->andReturn($query);

        $result = $this->extractor->query('foo');

        $this->assertSame($query, $result);
    }
}