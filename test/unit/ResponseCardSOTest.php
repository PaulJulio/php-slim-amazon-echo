<?php

use PaulJulio\SlimEcho\ResponseCardSO;

class ResponseCardSOTest extends PHPUnit_Framework_TestCase {

    public function testProperties() {
        $this->assertClassHasAttribute('type', ResponseCardSO::class);
        $this->assertClassHasAttribute('title', ResponseCardSO::class);
        $this->assertClassHasAttribute('content', ResponseCardSO::class);
        $this->assertEquals('Simple', ResponseCardSO::TYPE_SIMPLE);
        $this->assertEquals('LinkAccount', ResponseCardSO::TYPE_LINK_ACCOUNT);
        $this->assertEquals([ResponseCardSO::TYPE_SIMPLE, ResponseCardSO::TYPE_LINK_ACCOUNT], ResponseCardSO::ACCEPTED_TYPES);
    }

    public function testGetType() {
        $instance = new ResponseCardSO();
        $r = new ReflectionClass(ResponseCardSO::class);
        $p = $r->getProperty('type');
        $p->setAccessible(true);
        $p->setValue($instance, 'test type');
        $this->assertEquals('test type', $instance->getType());
    }

    /**
     * @expectedException Exception
     */
    public function testSetType() {
        $instance = new ResponseCardSO();
        $r = new ReflectionClass(ResponseCardSO::class);
        $p = $r->getProperty('type');
        $p->setAccessible(true);
        $instance->setType(ResponseCardSO::TYPE_SIMPLE);
        $this->assertEquals(ResponseCardSO::TYPE_SIMPLE, $p->getValue($instance));
        $instance->setType(ResponseCardSO::TYPE_LINK_ACCOUNT);
        $this->assertEquals(ResponseCardSO::TYPE_LINK_ACCOUNT, $p->getValue($instance));
        $instance->setType('invalid');
    }

    public function testGetTitle() {
        $instance = new ResponseCardSO();
        $r = new ReflectionClass(ResponseCardSO::class);
        $p = $r->getProperty('title');
        $p->setAccessible(true);
        $p->setValue($instance, 'test title');
        $this->assertEquals('test title', $instance->getTitle());
    }

    public function testSetTitle() {
        $instance = new ResponseCardSO();
        $r = new ReflectionClass(ResponseCardSO::class);
        $p = $r->getProperty('title');
        $p->setAccessible(true);
        $instance->setTitle('test title');
        $this->assertEquals('test title', $p->getValue($instance));
    }

    public function testGetContent() {
        $instance = new ResponseCardSO();
        $r = new ReflectionClass(ResponseCardSO::class);
        $p = $r->getProperty('content');
        $p->setAccessible(true);
        $p->setValue($instance, 'test content');
        $this->assertEquals('test content', $instance->getContent());
    }

    public function testSetContent() {
        $instance = new ResponseCardSO();
        $r = new ReflectionClass(ResponseCardSO::class);
        $p = $r->getProperty('content');
        $p->setAccessible(true);
        $instance->setContent('test content');
        $this->assertEquals('test content', $p->getValue($instance));
    }

    public function testIsValid() {
        $instance = new ResponseCardSO();
        $this->assertFalse($instance->isValid());
        $r = new ReflectionClass(ResponseCardSO::class);
        $p0 = $r->getProperty('type');
        $p1 = $r->getProperty('title');
        $p2 = $r->getProperty('content');
        $p0->setAccessible(true);
        $p1->setAccessible(true);
        $p2->setAccessible(true);
        $p0->setValue($instance, ResponseCardSO::TYPE_LINK_ACCOUNT);
        $p1->setValue($instance, 'some value');
        $this->assertFalse($instance->isValid());
        $instance = new ResponseCardSO();
        $p0->setValue($instance, ResponseCardSO::TYPE_LINK_ACCOUNT);
        $p2->setValue($instance, 'some content');
        $this->assertFalse($instance->isValid());
        $instance = new ResponseCardSO();
        $p0->setValue($instance, ResponseCardSO::TYPE_SIMPLE);
        $this->assertTrue($instance->isValid());
    }
}
