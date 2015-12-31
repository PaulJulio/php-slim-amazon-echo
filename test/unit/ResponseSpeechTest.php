<?php

use PaulJulio\SlimEcho\ResponseSpeech;
use PaulJulio\SlimEcho\ResponseSpeechSO;

class ResponseSpeechTest extends PHPUnit_Framework_TestCase {

    /* @var ResponseSpeechSO */
    private $somock;

    protected function setUp() {
        parent::setUp();
        $this->somock = Mockery::mock(ResponseSpeechSO::class);
    }

    protected function tearDown() {
        parent::tearDown();
        Mockery::close();
    }

    public function testProerties() {
        $this->assertClassHasAttribute('type', ResponseSpeech::class);
        $this->assertClassHasAttribute('text', ResponseSpeech::class);
        $this->assertClassHasAttribute('ssml', ResponseSpeech::class);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testFactoryNoArg() {
        $instance = ResponseSpeech::Factory();
    }

    /**
     * @expectedException Exception
     */
    public function testFactoryInvalidSO() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(false);
        $instance = ResponseSpeech::Factory($this->somock);
    }

    public function testFactoryReturnValue() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getType')
            ->once()
            ->andReturn('test value');
        $instance = ResponseSpeech::Factory($this->somock);
        $this->assertInstanceOf(ResponseSpeech::class, $instance);
    }

    public function testFactoryText() {
        $r = new ReflectionClass(ResponseSpeech::class);
        $p0 = $r->getProperty('type');
        $p1 = $r->getProperty('text');
        $p0->setAccessible(true);
        $p1->setAccessible(true);
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getType')
            ->once()
            ->andReturn(ResponseSpeechSO::TYPE_PLAIN_TEXT);
        $this->somock->shouldReceive('getText')
            ->once()
            ->andReturn('test text');
        $instance = ResponseSpeech::Factory($this->somock);
        $this->assertEquals(ResponseSpeechSO::TYPE_PLAIN_TEXT, $p0->getValue($instance));
        $this->assertEquals('test text', $p1->getValue($instance));
    }

    public function testFactorySsml() {
        $r = new ReflectionClass(ResponseSpeech::class);
        $p0 = $r->getProperty('type');
        $p1 = $r->getProperty('ssml');
        $p0->setAccessible(true);
        $p1->setAccessible(true);
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getType')
            ->once()
            ->andReturn(ResponseSpeechSO::TYPE_SSML);
        $this->somock->shouldReceive('getSsml')
            ->once()
            ->andReturn('test ssml');
        $instance = ResponseSpeech::Factory($this->somock);
        $this->assertEquals(ResponseSpeechSO::TYPE_SSML, $p0->getValue($instance));
        $this->assertEquals('test ssml', $p1->getValue($instance));
    }

    public function testGetAsArray() {
        $r = new ReflectionClass(ResponseSpeech::class);
        $p0 = $r->getProperty('type');
        $p1 = $r->getProperty('text');
        $p2 = $r->getProperty('ssml');
        $p0->setAccessible(true);
        $p1->setAccessible(true);
        $p2->setAccessible(true);
        /* @var ResponseSpeech */
        $instance = $r->newInstanceWithoutConstructor();
        $p0->setValue($instance, ResponseSpeechSO::TYPE_PLAIN_TEXT);
        $p1->setValue($instance, 'test text');
        $this->assertEquals(['type'=>ResponseSpeechSO::TYPE_PLAIN_TEXT,'text'=>'test text'], $instance->getAsArray());
        $instance = $r->newInstanceWithoutConstructor();
        $p0->setValue($instance, ResponseSpeechSO::TYPE_SSML);
        $p2->setValue($instance, 'test ssml');
        $this->assertEquals(['type'=>ResponseSpeechSO::TYPE_SSML,'ssml'=>'test ssml'], $instance->getAsArray());
    }
}
