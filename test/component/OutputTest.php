<?php

use \PaulJulio\SlimEcho\Response;
use \PaulJulio\SlimEcho\ResponseSpeech;
use \PaulJulio\SlimEcho\ResponseSpeechSO;
use \PaulJulio\StreamJSON\StreamJSON;
use \PaulJulio\SlimEcho\ResponseCard;
use \PaulJulio\SlimEcho\ResponseCardSO;

/**
 * Class ResponseTest
 *
 * this is why we don't mark things final (can't mock the json stream)
 */
class OutputTest extends PHPUnit_Framework_TestCase {

    public function testWriteToJsonStreamAll() {
        $js = new StreamJSON();
        $r = new ReflectionClass(Response::class);
        $speechSO = new ResponseSpeechSO();
        $speechSO->setType(ResponseSpeechSO::TYPE_PLAIN_TEXT);
        $speechSO->setText('speech text');
        $speech = ResponseSpeech::Factory($speechSO);
        $repromptSO = new ResponseSpeechSO();
        $repromptSO->setType(ResponseSpeechSO::TYPE_SSML);
        $repromptSO->setSsml('<p>sample ssml</p>');
        $reprompt = ResponseSpeech::Factory($repromptSO);
        $cardSO = new ResponseCardSO();
        $cardSO->setType(ResponseCardSO::TYPE_SIMPLE);
        $cardSO->setTitle("Sample Title");
        $cardSO->setContent("this is the content");
        $card = ResponseCard::Factory($cardSO);
        /* @var Response */
        $instance = $r->newInstanceWithoutConstructor();
        $p0 = $r->getProperty('version');
        $p1 = $r->getProperty('sessionAttributes');
        $p2 = $r->getProperty('outputSpeech');
        $p3 = $r->getProperty('reprompt');
        $p4 = $r->getProperty('card');
        $p5 = $r->getProperty('endSession');
        $p0->setAccessible(true);
        $p1->setAccessible(true);
        $p2->setAccessible(true);
        $p3->setAccessible(true);
        $p4->setAccessible(true);
        $p5->setAccessible(true);
        $p0->setValue($instance, '1.0');
        $p1->setValue($instance, ["first"=>["a"=>1,"b"=>"2"],"second"=>["c"=>null,"d"=>true]]);
        $p2->setValue($instance, $speech);
        $p3->setValue($instance, $reprompt);
        $p4->setValue($instance, $card);
        $p5->setValue($instance, true);
        $instance->writeToJsonStream($js);
        $this->assertEquals(
            json_encode([
                "version" => "1.0",
                "sessionAttributes" => [
                    "first" => [
                        "a"=>1,
                        "b"=>"2",
                        ],
                    "second" => [
                        "c" => null,
                        "d" => true,
                    ],
                ],
                "response" => [
                    "shouldEndSession" => true,
                    "outputSpeech" => [
                        "type" => ResponseSpeechSO::TYPE_PLAIN_TEXT,
                        "text" => "speech text"
                    ],
                    "reprompt" => [
                        "type" => ResponseSpeechSO::TYPE_SSML,
                        "ssml" => "<p>sample ssml</p>",
                    ],
                    "card" => [
                        "type" => ResponseCardSO::TYPE_SIMPLE,
                        "title" => "Sample Title",
                        "content" => "this is the content",
                    ],
                ],
            ]),
            (string) $js
        );
    }

    public function testWriteToJsonStreamMinimal() {
        $js = new StreamJSON();
        $r = new ReflectionClass(Response::class);
        /* @var Response */
        $instance = $r->newInstanceWithoutConstructor();
        $p0 = $r->getProperty('version');
        $p1 = $r->getProperty('endSession');
        $p0->setAccessible(true);
        $p1->setAccessible(true);
        $p0->setValue($instance, '1.0');
        $p1->setValue($instance, true);
        $instance->writeToJsonStream($js);
        $this->assertEquals(
            json_encode([
                "version" => "1.0",
                "response" => [
                    "shouldEndSession" => true,
                ],
            ]),
            (string) $js
        );
    }

}
