<?php
namespace PaulJulio\SlimEcho;

/**
 * Class ResponseSpeech
 * @package PaulJulio\SlimEcho
 */
class ResponseSpeech {

    private $type;
    private $text;
    private $ssml;

    private function __construct() {}

    /**
     * @param ResponseSpeechSO $so
     * @return ResponseSpeech
     * @throws \Exception
     */
    public static function Factory(ResponseSpeechSO $so) {
        if (!$so->isValid()) {
            throw new \Exception('Invalid Settings Object');
        }
        $instance = new self;
        $instance->type = $so->getType();
        switch ($instance->type) {
            case ResponseSpeechSO::TYPE_PLAIN_TEXT:
                $instance->text = $so->getText();
                break;
            case ResponseSpeechSO::TYPE_SSML:
                $instance->ssml = $so->getSsml();
                break;
        }
        return $instance;
    }

    /**
     * @return array
     *
     * An array suitable for passing to \PaulJulio\StreamJson\StreamJson
     */
    public function getAsArray() {
        $a = ['type'=>$this->type];
        switch ($this->type) {
            case ResponseSpeechSO::TYPE_PLAIN_TEXT:
                $a['text'] = $this->text;
                break;
            case ResponseSpeechSO::TYPE_SSML:
                $a['ssml'] = $this->ssml;
                break;
        }
        return $a;
    }
}