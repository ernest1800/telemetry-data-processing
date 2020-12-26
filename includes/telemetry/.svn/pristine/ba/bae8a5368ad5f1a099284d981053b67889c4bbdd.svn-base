<?php

namespace Telemetry;

use PHPUnit\Framework\TestCase;

class XmlParserTest extends TestCase
{
    protected $xml_string_correct = "<messagerx><sourcemsisdn>447817814149</sourcemsisdn><destinationmsisdn>447817814149</destinationmsisdn><receivedtime>14/12/2020 20:26:45</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><d_id>AF72</d_id><a>1</a><b>1</b><c>1</c><d>0</d><fan>0</fan><h_temp>12.0<h_temp><key>3</key></message></messagerx>";
    protected $xml_string_incorrect = "bad_string 03498 message";

    protected $expected_message_correct = [
        'SOURCEMSISDN' => '447817814149',
        'DESTINATIONMSISDN' => '447817814149',
        'RECEIVEDTIME' => '14/12/2020 20:26:45',
        'BEARER' => 'SMS',
        'MESSAGEREF' => '0',
        'D_ID' => 'AF72',
        'A' => '1',
        'B' => '1',
        'C' => '1',
        'D' => '0',
        'FAN' => '0',
        'H_TEMP' => '12.0',
        'KEY' => '3',
    ];

    protected $expected_message_incorrect = [];

    /**
     * Correct string passed expect array result
     */
    public function testXmlParsingCorrect()
    {
        $xml_parser = new XmlParser();
        $xml_parser->setXmlStringToParse($this->xml_string_correct);
        $xml_parser->parseTheXmlString();
        $this->assertEquals($this->expected_message_correct, $xml_parser->getParsedData());
    }

    /**
     *  Incorrect string passed expect empty array
     */
    public function testXmlParsingInorrect()
    {
        $xml_parser = new XmlParser();
        $xml_parser->setXmlStringToParse($this->xml_string_incorrect);
        $xml_parser->parseTheXmlString();
        $this->assertEquals($this->expected_message_incorrect, $xml_parser->getParsedData());
    }
}