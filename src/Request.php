<?php
namespace PaulJulio\SlimEcho;

/**
 * Class Request
 * @package PaulJulio\SlimEcho
 */
class Request {

    protected $httpRequest;

    private function __construct() {
    }

    /**
     * @param RequestSO $so
     * @return Request|RequestIntent|RequestLaunch|RequestSessionEnded
     * @throws \Exception
     */
    public static function Factory(RequestSO $so) {
        if (!$so->isValid()) {
            throw new \Exception('Invalid Settings Object');
        }
        $httpRequest = $so->getHttpRequest();
        $decoded = json_decode($httpRequest);
        switch($decoded->request->type) {
            case 'IntentRequest':
                $instance = new RequestIntent();
                break;
            case 'LaunchRequest':
                $instance = new RequestLaunch();
                break;
            case 'SessionEndedRequest':
                $instance = new RequestSessionEnded();
                break;
            default:
                $instance = new self;
        }
        $instance->httpRequest = $decoded;
        return $instance;
    }

    /**
     * @return double
     */
    public function getVersion() {
        return $this->httpRequest->version;
    }

    /**
     * @return bool
     */
    public function isNewSession() {
        return $this->httpRequest->session->new;
    }

    /**
     * @return string
     */
    public function getSessionID() {
        return $this->httpRequest->session->sessionId;
    }

    /**
     * @return string
     */
    public function getApplicationID() {
        return $this->httpRequest->session->application->applicationId;
    }

    /**
     * @return array
     *
     * converts the stdClass for the attributes to an array and returns it
     */
    public function getAttributes() {
        return json_decode(json_encode($this->httpRequest->session->attributes),true);
    }

    /**
     * @return string
     */
    public function getUserID() {
        return $this->httpRequest->session->user->userId;
    }

    /**
     * @return null|string
     */
    public function getAuthToken() {
        if (property_exists($this->httpRequest->session->user, 'accessToken')) {
            return $this->httpRequest->session->user->accessToken;
        }
        return null;
    }

    /**
     * @return string
     */
    public function getRequestType() {
        return $this->httpRequest->request->type;
    }

    /**
     * @return string
     */
    public function getTimestamp() {
        return $this->httpRequest->request->timestamp;
    }

    /**
     * @return string
     */
    public function getRequestID() {
        return $this->httpRequest->request->requestId;
    }
}