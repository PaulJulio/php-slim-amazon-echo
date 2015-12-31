<?php
namespace PaulJulio\SlimEcho;

/**
 * Class ResponseCard
 * @package PaulJulio\SlimEcho
 */
class ResponseCard {

    /* @var string */
    private $type;
    /* @var string */
    private $title;
    /* @var string */
    private $content;

    private function __construct() {}

    /**
     * @param ResponseCardSO $so
     * @return ResponseCard
     * @throws \Exception
     */
    public static function Factory(ResponseCardSO $so) {
        if (!$so->isValid()) {
            throw new \Exception('Invalid Settings Object');
        }
        $instance = new self;
        $instance->type = $so->getType();
        if ($instance->type != ResponseCardSO::TYPE_LINK_ACCOUNT) {
            $instance->title = $so->getTitle();
            $instance->content = $so->getContent();
        }
        return $instance;
    }

    /**
     * @return array
     *
     * An array suitable for passing to \PaulJulio\StreamJson\StreamJson
     */
    public function getAsArray() {
        $a = [];
        if (isset($this->type)) {
            $a['type'] = $this->type;
        }
        if (isset($this->title)) {
            $a['title'] = $this->title;
        }
        if (isset($this->content)) {
            $a['content'] = $this->content;
        }
        return $a;
    }
}