<?php
use PaulJulio\SlimEcho\ResponseSO;
use PaulJulio\SlimEcho\ResponseSpeech;
use PaulJulio\SlimEcho\ResponseCard;

class ResponseSOTest extends PHPUnit_Framework_TestCase {

    public function testProperties() {
        $this->assertClassHasAttribute('version', ResponseSO::class);
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('version');
        $p->setAccessible(true);
        $instance = new ResponseSO();
        $this->assertEquals('1.0', $p->getValue($instance));
        $this->assertClassHasAttribute('sessionAttributes', ResponseSO::class);
        $p2 = $r->getProperty('sessionAttributes');
        $p2->setAccessible(true);
        $this->assertInternalType('array', $p2->getValue($instance));
        $this->assertClassHasAttribute('outputSpeech', ResponseSO::class);
        $this->assertClassHasAttribute('reprompt', ResponseSO::class);
        $this->assertClassHasAttribute('card', ResponseSO::class);
        $this->assertClassHasAttribute('continueSession', ResponseSO::class);
    }

    public function testGetVersion() {
        $instance = new ResponseSO();
        $this->assertEquals('1.0', $instance->getVersion());
    }

    public function testSetAttribute() {
        $instance = new ResponseSO();
        $instance->setAttribute('foo', ['bar'=>'baz']);
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('sessionAttributes');
        $p->setAccessible(true);
        $this->assertEquals(['foo'=>['bar'=>'baz']], $p->getValue($instance));
    }

    public function testUnsetAttribute() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('sessionAttributes');
        $p->setAccessible(true);
        $p->setValue($instance, ['foo'=>'bar']);
        $instance->unsetAttribute('foo');
        $this->assertArrayNotHasKey('foo', $p->getValue($instance));
    }

    public function testGetAttributes() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('sessionAttributes');
        $p->setAccessible(true);
        $a = ['session'=>['a'=>'1','b'=>'2']];
        $p->setValue($instance, $a);
        $this->assertSame($a, $instance->getAttributes());
    }

    public function testSetOutputSpeech() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('outputSpeech');
        $p->setAccessible(true);
        $m = Mockery::mock(ResponseSpeech::class);
        $instance->setOutputSpeech($m);
        $this->assertSame($m, $p->getValue($instance));
    }

    public function testGetOutputSpeech() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $m = Mockery::mock(ResponseSpeech::class);
        $p = $r->getProperty('outputSpeech');
        $p->setAccessible(true);
        $p->setValue($instance, $m);
        $this->assertSame($m, $instance->getOutputSpeech());
    }

    public function testSetReprompt() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('reprompt');
        $p->setAccessible(true);
        $m = Mockery::mock(ResponseSpeech::class);
        $instance->setReprompt($m);
        $this->assertSame($m, $p->getValue($instance));
    }

    public function testGetReprompt() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $m = Mockery::mock(ResponseSpeech::class);
        $p = $r->getProperty('reprompt');
        $p->setAccessible(true);
        $p->setValue($instance, $m);
        $this->assertSame($m, $instance->getReprompt());
    }

    public function testGetCard() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('card');
        $p->setAccessible(true);
        $m = Mockery::mock(ResponseCard::class);
        $p->setValue($instance, $m);
        $this->assertSame($m, $instance->getCard());
    }

    public function testSetCard() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('card');
        $p->setAccessible(true);
        $m = Mockery::mock(ResponseCard::class);
        $instance->setCard($m);
        $this->assertSame($m, $p->getValue($instance));
    }

    public function testEndSession() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('continueSession');
        $p->setAccessible(true);
        $instance->endSession();
        $this->assertFalse($p->getValue($instance));
    }

    public function testContinueSession() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('continueSession');
        $p->setAccessible(true);
        $instance->ContinueSession();
        $this->assertTrue($p->getValue($instance));
    }

    public function testIsContinueSession() {
        $instance = new ResponseSO();
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('continueSession');
        $p->setAccessible(true);
        $p->setValue($instance, 0);
        $this->assertFalse($instance->isContinueSession());
        $p->setValue($instance, 1);
        $this->assertTrue($instance->isContinueSession());
    }

    public function testIsValid() {
        $instance = new ResponseSO();
        $this->assertFalse($instance->isValid());
        $r = new ReflectionClass(ResponseSO::class);
        $p = $r->getProperty('continueSession');
        $p->setAccessible(true);
        $p->setValue($instance, true);
        $this->assertTrue($instance->isValid());
    }
}
