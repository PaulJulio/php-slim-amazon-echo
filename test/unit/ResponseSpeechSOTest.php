<?php
use PaulJulio\SlimEcho\ResponseSpeechSO;

class ResponseSpeechSOTest extends PHPUnit_Framework_TestCase {

    public function testProperties() {
        $this->assertClassHasAttribute('type', ResponseSpeechSO::class);
        $this->assertClassHasAttribute('text', ResponseSpeechSO::class);
        $this->assertClassHasAttribute('ssml', ResponseSpeechSO::class);
        $r = new ReflectionClass(ResponseSpeechSO::class);
        $this->assertEquals('PlainText', $r->getConstant('TYPE_PLAIN_TEXT'));
        $this->assertEquals('SSML', $r->getConstant('TYPE_SSML'));
        $this->assertEquals([$r->getConstant('TYPE_PLAIN_TEXT'), $r->getConstant('TYPE_SSML')], $r->getConstant('ALLOWED_TYPES'));
    }

    /**
     * @expectedException Exception
     */
    public function testSetType() {
        $r = new ReflectionClass(ResponseSpeechSO::class);
        $p = $r->getProperty('type');
        $p->setAccessible(true);
        $instance = new ResponseSpeechSO();
        $instance->setType($instance::TYPE_PLAIN_TEXT);
        $this->assertEquals(ResponseSpeechSO::TYPE_PLAIN_TEXT, $p->getValue($instance));
        $instance->setType($instance::TYPE_SSML);
        $this->assertEquals(ResponseSpeechSO::TYPE_SSML, $p->getValue($instance));
        $instance->setType('foo');
    }

    public function testGetType() {
        $r = new ReflectionClass(ResponseSpeechSO::class);
        $p = $r->getProperty('type');
        $p->setAccessible(true);
        $instance = new ResponseSpeechSO();
        $p->setValue($instance, 'test value');
        $this->assertEquals('test value', $instance->getType());
    }

    public function testSetText() {
        $r = new ReflectionClass(ResponseSpeechSO::class);
        $p = $r->getProperty('text');
        $p->setAccessible(true);
        $instance = new ResponseSpeechSO();
        $instance->setText('test text');
        $this->assertEquals('test text', $p->getValue($instance));
    }

    public function testGetText() {
        $r = new ReflectionClass(ResponseSpeechSO::class);
        $p = $r->getProperty('text');
        $p->setAccessible(true);
        $instance = new ResponseSpeechSO();
        $p->setValue($instance, 'test value');
        $this->assertEquals('test value', $instance->getText());
    }

    public function testSetSsml() {
        $r = new ReflectionClass(ResponseSpeechSO::class);
        $p = $r->getProperty('ssml');
        $p->setAccessible(true);
        $instance = new ResponseSpeechSO();
        $instance->setSsml('test ssml');
        $this->assertEquals('test ssml', $p->getValue($instance));
    }

    public function testGetSsml() {
        $r = new ReflectionClass(ResponseSpeechSO::class);
        $p = $r->getProperty('ssml');
        $p->setAccessible(true);
        $instance = new ResponseSpeechSO();
        $p->setValue($instance, 'ssml test');
        $this->assertEquals('ssml test', $instance->getSsml());
    }

    public function testIsValid() {
        $r = new ReflectionClass(ResponseSpeechSO::class);
        $p0 = $r->getProperty('type');
        $p1 = $r->getProperty('text');
        $p2 = $r->getProperty('ssml');
        $p0->setAccessible(true);
        $p1->setAccessible(true);
        $p2->setAccessible(true);
        $instance = new ResponseSpeechSO();
        $this->assertFalse($instance->isValid());
        $p0->setValue($instance, $instance::TYPE_PLAIN_TEXT);
        $this->assertFalse($instance->isValid());
        $p1->setValue($instance, 'test value');
        $this->assertTrue($instance->isValid());
        $instance = new ResponseSpeechSO();
        $p0->setValue($instance, $instance::TYPE_SSML);
        $this->assertFalse($instance->isValid());
        $p2->setValue($instance, 'test ssml');
        $this->assertTrue($instance->isValid());
    }
}
