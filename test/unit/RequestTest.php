<?php
use PaulJulio\SlimEcho\Request;
use PaulJulio\SlimEcho\RequestIntent;
use PaulJulio\SlimEcho\RequestSessionEnded;
use PaulJulio\SlimEcho\RequestSO;

class RequestTest extends PHPUnit_Framework_TestCase {

    /** @var  RequestSO a mock object for testing */
    private $somock;

    protected function setUp() {
        parent::setUp();
        $this->somock = Mockery::mock(RequestSO::class);
    }

    protected function tearDown() {
        parent::tearDown();
        Mockery::close();
    }

    public function testProperties() {
        $this->assertClassHasAttribute('httpRequest', Request::class);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testFactoryNoArgs() {
        $instance = Request::Factory();
    }

    /**
     * @expectedException Exception
     */
    public function testFactoryInvalidSO() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(false);
        $instance = Request::Factory($this->somock);
    }

    public function testFactoryValidSO() {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json');
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getHttpRequest')
            ->once()
            ->andReturn($json);
        $instance = Request::Factory($this->somock);
        $r = new ReflectionClass(Request::class);
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $this->assertEquals(json_decode($json), $p->getValue($instance));
    }

    public function testFactoryIntent() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getHttpRequest')
            ->once()
            ->andReturn(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json'));
        $instance = Request::Factory($this->somock);
        $this->assertInstanceOf(\PaulJulio\SlimEcho\RequestIntent::class, $instance);
    }

    public function testFactoryLaunch() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getHttpRequest')
            ->once()
            ->andReturn(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'launch-request.json'));
        $instance = Request::Factory($this->somock);
        $this->assertInstanceOf(\PaulJulio\SlimEcho\RequestLaunch::class, $instance);
    }

    public function testFactorySessionEnded() {
        $this->somock->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->somock->shouldReceive('getHttpRequest')
            ->once()
            ->andReturn(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'session-ended-request.json'));
        $instance = Request::Factory($this->somock);
        $this->assertInstanceOf(\PaulJulio\SlimEcho\RequestSessionEnded::class, $instance);
    }

    public function testGetVersion() {
        $r = new ReflectionClass(Request::class);
        /* @var Request $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $this->assertEquals('1.0', $instance->getVersion());
    }

    public function testIsNewSession() {
        $r = new ReflectionClass(Request::class);
        /* @var Request $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $this->assertFalse($instance->isNewSession());
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'launch-request.json')));
        $this->assertTrue($instance->isNewSession());
    }

    public function testGetSessionID() {
        $r = new ReflectionClass(Request::class);
        /* @var Request $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $this->assertEquals('amzn1.echo-api.session.0000000-0000-0000-0000-00000000000', $instance->getSessionID());
    }

    public function testGetApplicationID() {
        $r = new ReflectionClass(Request::class);
        /* @var Request $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $this->assertEquals("amzn1.echo-sdk-ams.app.000000-d0ed-0000-ad00-000000d00ebe", $instance->getApplicationID());
    }

    public function testGetAttributes() {
        $r = new ReflectionClass(Request::class);
        /* @var Request $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $assoc = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json'),true);
        $this->assertEquals($assoc['session']['attributes'], $instance->getAttributes());
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'launch-request.json')));
        $this->assertEquals([], $instance->getAttributes());
    }

    public function testGetUserID() {
        $r = new ReflectionClass(Request::class);
        /* @var Request $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $this->assertEquals('amzn1.account.AM3B00000000000000000000000', $instance->getUserID());
    }

    public function testGetAuthToken() {
        $r = new ReflectionClass(Request::class);
        /* @var Request $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'session-ended-request.json')));
        $this->assertEquals('some token', $instance->getAuthToken());
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $this->assertNull($instance->getAuthToken());
    }

    public function testGetRequestType() {
        $r = new ReflectionClass(Request::class);
        /* @var Request $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'session-ended-request.json')));
        $this->assertEquals('SessionEndedRequest', $instance->getRequestType());
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $this->assertEquals('IntentRequest', $instance->getRequestType());
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'launch-request.json')));
        $this->assertEquals('LaunchRequest', $instance->getRequestType());
    }

    public function testGetTimestamp() {
        $r = new ReflectionClass(Request::class);
        /* @var Request $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $this->assertEquals('2015-05-13T12:34:56Z', $instance->getTimestamp());
    }

    public function testGetRequestID() {
        $r = new ReflectionClass(Request::class);
        /* @var Request $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $this->assertEquals('amzn1.echo-api.request.0000000-0000-0000-0000-00000000000', $instance->getRequestID());
    }

    public function testGetReason() {
        $r = new ReflectionClass(RequestSessionEnded::class);
        /* @var RequestSessionEnded $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'session-ended-request.json')));
        $this->assertEquals('USER_INITIATED', $instance->getReason());
    }

    public function testGetName() {
        $r = new ReflectionClass(RequestIntent::class);
        /* @var RequestIntent $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $this->assertEquals('GetZodiacHoroscopeIntent', $instance->getName());
    }

    public function testGetSlots() {
        $r = new ReflectionClass(RequestIntent::class);
        /* @var RequestIntent $instance */
        $instance = $r->newInstanceWithoutConstructor();
        $p = $r->getProperty('httpRequest');
        $p->setAccessible(true);
        $p->setValue($instance, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json')));
        $assoc = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'intent-request.json'),true);
        $this->assertEquals($assoc['request']['intent']['slots'], $instance->getSlots());
    }

}
