<?php

use PaulJulio\SlimEcho\ResponseCard;
use PaulJulio\SlimEcho\ResponseCardSO;

class ResponseCardTest extends PHPUnit_Framework_TestCase {

    /* @var ResponseCardSO */
    private $somock;

    protected function setUp() {
        parent::setUp();
        $this->somock = Mockery::mock(ResponseCardSO::class);
    }

    protected function tearDown() {
        parent::tearDown();
        Mockery::close();
    }

    public function testProperties() {
        $this->assertClassHasAttribute('type', ResponseCard::class);
        $this->assertClassHasAttribute('title', ResponseCard::class);
        $this->assertClassHasAttribute('content', ResponseCard::class);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testFactoryNoArg() {
        $instance = ResponseCard::Factory();
    }

    /**
     * @expectedException Exception
     */
    public function testFactoryInvalidSO() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(false);
        $instance = ResponseCard::Factory($this->somock);
    }

    public function testFactoryReturnValue() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getType')
            ->once()
            ->andReturn('test value');
        $this->somock->shouldReceive('getTitle')
            ->once()
            ->andReturn(null);
        $this->somock->shouldReceive('getContent')
            ->once()
            ->andReturn(null);
        $instance = ResponseCard::Factory($this->somock);
        $this->assertInstanceOf(ResponseCard::class, $instance);
    }

    public function testFactorySimple() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getType')
            ->once()
            ->andReturn(ResponseCardSO::TYPE_SIMPLE);
        $this->somock->shouldReceive('getTitle')
            ->once()
            ->andReturn('test title');
        $this->somock->shouldReceive('getContent')
            ->once()
            ->andReturn('test content');
        $instance = ResponseCard::Factory($this->somock);
        $r = new ReflectionClass(ResponseCard::class);
        $p0 = $r->getProperty('type');
        $p1 = $r->getProperty('title');
        $p2 = $r->getProperty('content');
        $p0->setAccessible(true);
        $p1->setAccessible(true);
        $p2->setAccessible(true);
        $this->assertEquals(ResponseCardSO::TYPE_SIMPLE, $p0->getValue($instance));
        $this->assertEquals('test title', $p1->getValue($instance));
        $this->assertEquals('test content', $p2->getValue($instance));
    }

    public function testFactoryLinkAccount() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getType')
            ->once()
            ->andReturn(ResponseCardSO::TYPE_LINK_ACCOUNT);
        $this->somock->shouldReceive('getTitle')
            ->never();
        $this->somock->shouldReceive('getContent')
            ->never();
        $instance = ResponseCard::Factory($this->somock);
        $r = new ReflectionClass(ResponseCard::class);
        $p = $r->getProperty('type');
        $p->setAccessible(true);
        $this->assertEquals(ResponseCardSO::TYPE_LINK_ACCOUNT, $p->getValue($instance));
    }

    public function testGetAsArray() {
        $r = new ReflectionClass(ResponseCard::class);
        $p0 = $r->getProperty('type');
        $p1 = $r->getProperty('title');
        $p2 = $r->getProperty('content');
        $p0->setAccessible(true);
        $p1->setAccessible(true);
        $p2->setAccessible(true);
        /* @var ResponseCard */
        $instance = $r->newInstanceWithoutConstructor();
        $p0->setValue($instance, ResponseCardSO::TYPE_LINK_ACCOUNT);
        $this->assertSame(['type'=>ResponseCardSO::TYPE_LINK_ACCOUNT], $instance->getAsArray());
        $p0->setValue($instance, ResponseCardSO::TYPE_SIMPLE);
        $p1->setValue($instance, 'test title');
        $p2->setValue($instance, 'test content');
        $this->assertSame([
            'type'=>ResponseCardSO::TYPE_SIMPLE,
            'title' => 'test title',
            'content' => 'test content',
        ], $instance->getAsArray());
    }
}
