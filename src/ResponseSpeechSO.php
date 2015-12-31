<?php
namespace PaulJulio\SlimEcho;

/**
 * Class ResponseSpeechSO
 * @package PaulJulio\SlimEcho
 *
 * ToDo: validate SSML
 */
class ResponseSpeechSO {

    const TYPE_PLAIN_TEXT = 'PlainText';
    const TYPE_SSML = 'SSML';
    const ALLOWED_TYPES = [self::TYPE_PLAIN_TEXT, self::TYPE_SSML];

    private $type;
    private $text;
    private $ssml;

    /**
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text) {
        $this->text = (string) $text;
    }

    /**
     * @return string
     */
    public function getSsml() {
        return $this->ssml;
    }

    /**
     * @param string $ssml
     */
    public function setSsml($ssml) {
        $this->ssml = (string) $ssml;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     * @throws \Exception
     */
    public function setType($type) {
        if (!in_array($type, self::ALLOWED_TYPES)) {
            throw new \Exception('Unrecognized type');
        }
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isValid() {
        if (!in_array($this->type, self::ALLOWED_TYPES)) {
            return false;
        }
        if ($this->type === self::TYPE_PLAIN_TEXT && !is_string($this->text)) {
            return false;
        }
        if ($this->type === self::TYPE_SSML && !is_string($this->ssml)) {
            return false;
        }
        return true;
    }
}