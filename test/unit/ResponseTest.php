<?php
use PaulJulio\SlimEcho\Response;
use PaulJulio\SlimEcho\ResponseSO;
use PaulJulio\SlimEcho\ResponseSpeech;
use PaulJulio\SlimEcho\ResponseCard;

class ResponseTest extends PHPUnit_Framework_TestCase {

    /** @var  ResponseSO a mock object for testing */
    private $somock;

    protected function setUp() {
        parent::setUp();
        $this->somock = Mockery::mock(ResponseSO::class);
    }

    protected function tearDown() {
        parent::tearDown();
        Mockery::close();
    }
    public function testProperties() {
        $this->assertClassHasAttribute('version', Response::class);
        $this->assertClassHasAttribute('sessionAttributes', Response::class);
        $this->assertClassHasAttribute('outputSpeech', Response::class);
        $this->assertClassHasAttribute('reprompt', Response::class);
        $this->assertClassHasAttribute('card', Response::class);
        $this->assertClassHasAttribute('endSession', Response::class);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testFactoryNoArgs() {
        $instance = Response::Factory();
    }

    /**
     * @expectedException Exception
     */
    public function testFactoryInvalidSO() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(false);
        $instance = Response::Factory($this->somock);
    }

    public function testFactoryValidSO() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getVersion')
            ->once()
            ->andReturn('test version');
        $v1 = ['test attrs'=>['a'=>'1','b'=>'2']];
        $this->somock->shouldReceive('getAttributes')
            ->once()
            ->andReturn($v1);
        $m2 = Mockery::mock(ResponseSpeech::class);
        $this->somock->shouldReceive('getOutputSpeech')
            ->once()
            ->andReturn($m2);
        $m3 = Mockery::mock(ResponseSpeech::class);
        $this->somock->shouldReceive('getReprompt')
            ->once()
            ->andReturn($m3);
        $m4 = Mockery::mock(ResponseCard::class);
        $this->somock->shouldReceive('getCard')
            ->once()
            ->andReturn($m4);
        $this->somock->shouldReceive('isContinueSession')
            ->once()
            ->andReturn(true);
        $instance = Response::Factory($this->somock);
        $this->assertInstanceOf(Response::class, $instance);
        $r = new ReflectionClass(Response::class);
        $p0 = $r->getProperty('version');
        $p1 = $r->getProperty('sessionAttributes');
        $p2 = $r->getProperty('outputSpeech');
        $p3 = $r->getProperty('reprompt');
        $p4 = $r->getProperty('card');
        $p5 = $r->getProperty('endSession');
        $p0->setAccessible(true);
        $p1->setAccessible(true);
        $p2->setAccessible(true);
        $p3->setAccessible(true);
        $p4->setAccessible(true);
        $p5->setAccessible(true);
        $this->assertEquals('test version', $p0->getValue($instance));
        $this->assertSame($v1, $p1->getValue($instance));
        $this->assertSame($m2, $p2->getValue($instance));
        $this->assertSame($m3, $p3->getValue($instance));
        $this->assertSame($m4, $p4->getValue($instance));
        $this->assertFalse($p5->getValue($instance));
    }

}
