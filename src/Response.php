<?php
namespace PaulJulio\SlimEcho;

class Response {

    /* @var string */
    private $version;
    /* @var array */
    private $sessionAttributes;
    /* @var ResponseSpeech */
    private $outputSpeech;
    /* @var ResponseSpeech */
    private $reprompt;
    /* @var ResponseCard */
    private $card;
    /* @var bool */
    private $endSession;

    public static function Factory(ResponseSO $so) {
        if (!$so->isValid()) {
            throw new \Exception('Invalid Settings Object');
        }
        $instance = new self;
        $instance->version = $so->getVersion();
        $instance->sessionAttributes = $so->getAttributes();
        $instance->outputSpeech = $so->getOutputSpeech();
        $instance->reprompt = $so->getReprompt();
        $instance->card = $so->getCard();
        $instance->endSession = !$so->isContinueSession();
        return $instance;
    }

    public function writeToJsonStream(\PaulJulio\StreamJSON\StreamJSON $stream) {
        $stream->offsetSet('version', $this->version);
        if (isset($this->sessionAttributes)) {
            $stream->offsetSet('sessionAttributes', $this->sessionAttributes);
        }
        $response = ['shouldEndSession'=>$this->endSession];
        if (isset($this->outputSpeech)) {
            $response['outputSpeech'] = $this->outputSpeech->getAsArray();
        }
        if (isset($this->reprompt)) {
            $response['reprompt'] = $this->reprompt->getAsArray();
        }
        if (isset($this->card)) {
            $response['card'] = $this->card->getAsArray();
        }
        $stream->offsetSet('response', $response);
    }
}