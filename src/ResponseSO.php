<?php
namespace PaulJulio\SlimEcho;

class ResponseSO {

    private $version = '1.0';
    private $sessionAttributes = [];
    /* @var ResponseSpeech */
    private $outputSpeech;
    /* @var ResponseSpeech */
    private $reprompt;
    /* @var ResponseCard */
    private $card;
    /* @var bool */
    private $continueSession;

    public function isValid() {
        if (!is_bool($this->continueSession)) {
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * @param $attribute
     * @param $value
     */
    public function setAttribute($attribute, array $value) {
        $this->sessionAttributes[$attribute] = $value;
    }

    /**
     * @param $attribute
     */
    public function unsetAttribute($attribute) {
        unset($this->sessionAttributes[$attribute]);
    }

    public function getAttributes() {
        return $this->sessionAttributes;
    }

    /**
     * @return null|ResponseSpeech
     */
    public function getOutputSpeech() {
        return $this->outputSpeech;
    }

    /**
     * @param mixed $outputSpeech
     */
    public function setOutputSpeech($outputSpeech) {
        $this->outputSpeech = $outputSpeech;
    }

    /**
     * @return null|ResponseSpeech
     */
    public function getReprompt() {
        return $this->reprompt;
    }

    /**
     * @param ResponseSpeech $reprompt
     */
    public function setReprompt($reprompt) {
        $this->reprompt = $reprompt;
    }

    /**
     * @return null|ResponseCard
     */
    public function getCard() {
        return $this->card;
    }

    /**
     * @param ResponseCard $card
     */
    public function setCard(ResponseCard $card) {
        $this->card = $card;
    }

    public function endSession() {
        $this->continueSession = false;
    }

    public function continueSession() {
        $this->continueSession = true;
    }

    public function isContinueSession() {
        return (bool) $this->continueSession;
    }
}