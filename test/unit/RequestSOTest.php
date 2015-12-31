<?php

class RequestSOTest extends PHPUnit_Framework_TestCase {

    public function testProperties() {
        $this->assertClassHasAttribute('httpRequest', \PaulJulio\SlimEcho\RequestSO::class);
    }

    public function testSetHttpRequest() {
        $simock = $this->getSIMock();
        $this->assertInstanceOf('\Psr\Http\Message\StreamInterface', $simock);
        $so = new \PaulJulio\SlimEcho\RequestSO();
        $so->setHttpRequest($simock);
        $r = new ReflectionClass(\PaulJulio\SlimEcho\RequestSO::class);
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $this->assertSame($simock, $p->getValue($so));
        Mockery::close();
    }

    public function testIsValid() {
        $simock = $this->getSIMock();
        $so = new \PaulJulio\SlimEcho\RequestSO();
        $r = new ReflectionClass(\PaulJulio\SlimEcho\RequestSO::class);
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($so, $simock);
        $this->assertTrue($so->isValid());
        Mockery::close();
    }

    public function testGetHttpRequest() {
        $simock = $this->getSIMock();
        $so = new \PaulJulio\SlimEcho\RequestSO();
        $r = new ReflectionClass(\PaulJulio\SlimEcho\RequestSO::class);
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($so, $simock);
        $this->assertSame($simock, $so->getHttpRequest());
        Mockery::close();
    }

    private function getSIMock() {
        return \Mockery::mock('\Psr\Http\Message\StreamInterface');
    }
}
