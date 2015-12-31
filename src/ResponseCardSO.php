<?php
namespace PaulJulio\SlimEcho;

class ResponseCardSO {

    const TYPE_SIMPLE = 'Simple';
    const TYPE_LINK_ACCOUNT = 'LinkAccount';
    const ACCEPTED_TYPES = [self::TYPE_SIMPLE, self::TYPE_LINK_ACCOUNT];

    /* @var string */
    private $type;
    /* @var string */
    private $title;
    /* @var string */
    private $content;

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
        if (!in_array($type, self::ACCEPTED_TYPES)) {
            throw new \Exception('Invalid type');
        }
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = (string) $title;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content) {
        $this->content = (string) $content;
    }

    /**
     * @return bool
     */
    public function isValid() {
        if (!in_array($this->type, self::ACCEPTED_TYPES)) {
            return false;
        }
        if ($this->type == self::TYPE_LINK_ACCOUNT && (isset($this->title) || isset($this->content))) {
            return false;
        }
        return true;
    }
}