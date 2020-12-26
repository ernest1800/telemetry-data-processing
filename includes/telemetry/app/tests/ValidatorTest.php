<?php
/**
 *  ValidatorTest
 *  Validator is a model that validates multidimensional arrays where the child array is a message and the parent is an
 *  array of messages
 */

namespace Telemetry;


use PHPUnit\Framework\TestCase;
use Telemetry\Validator;

class ValidatorTest extends TestCase
{

    protected $device_id = "AF72";
    protected $correct_messages = [
        [
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
        ]
        ,
        [
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
        ]
    ];

    protected $incorrect_messages = [
        [
            'UNEXPECTED_TAG' => '81234234',
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
        ]
        ,
        [
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
        ]
    ];

    protected $bad_messages = [
        ["bad" => "123"],
        ["bad" => "456"],
        [
            'SOURCEMSISDN' => '447817814149',
            'DESTINATIONMSISDN' => '447817814149',
            'RECEIVEDTIME' => '14/12/2020 20:26:45',
            'BEARER' => 'SMS',
            'MESSAGEREF' => '0',
            'D_ID' => 'AF72',
            'A' => '2',
            'B' => '1',
            'C' => '1',
            'D' => '0',
            'FAN' => '0',
            'H_TEMP' => '12.0',
            'KEY' => '3',
        ]
        ];

    protected $correct_settings = [
        'A' => '1',
        'B' => '1',
        'C' => '1',
        'D' => '0',
        'FAN' => '0',
        'H_TEMP' => '12.0',
        'KEY' => '3',
    ];

    protected $incorrect_settings = [
        'A' => '2',
        'B' => '1',
        'C' => '1',
        'D' => '1',
        'FAN' => '0',
        'H_TEMP' => '1',
        'KEY' => '3',
    ];

    protected $bad_settings = ["asd" => "XAS"];

    /**
     * Test correct input. expect output to be equal to input
     */
    public function testValidateMessagesCorrect()
    {
        $expected = $this->correct_messages;
        $validator = new Validator();
        $result = $validator->validateMessages($this->correct_messages, $this->device_id);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test to see if single messasge is validated correctly
     */
    public function testValidateSingleMessage()
    {
        $expected = [$this->correct_messages[0]];
        $validator = new Validator();
        $result = $validator->validateMessages([$this->correct_messages[0]] , $this->device_id);
        $this->assertEquals($expected, $result);
    }

    /**
     * Should return array with unrecognised tags omitted
     */
    public function testValidateMessagesUnrecognisedTag()
    {
        $expected = $this->correct_messages;
        $validator = new Validator();
        $result = $validator->validateMessages($this->incorrect_messages , $this->device_id);
        $this->assertEquals($expected, $result);
    }

    /**
     *  Test array with two bad messages and one good message
     *  should return only valid messages within array
     */
    public function testValidateBadMessage()
    {
        $expected = [];
        $validator = new Validator();
        $result = $validator->validateMessages($this->bad_messages , $this->device_id);
        $this->assertEquals($expected, $result);
    }

    public function testValidateSettingsDataCorrect(){
        $expected = $this->correct_settings;
        $validator = new Validator();
        $result = $validator->validateSettingsData($this->correct_settings);
        $this->assertEquals($expected, $result);
    }

    public function testValidateSettingsDataIncorrect(){
        $expected = [];
        $validator = new Validator();
        $result = $validator->validateSettingsData($this->incorrect_settings);
        $this->assertEquals($expected, $result);
    }

    public function testValidateSettingsDataBad(){
        $expected = [];
        $validator = new Validator();
        $result = $validator->validateSettingsData($this->bad_settings);
        $this->assertEquals($expected, $result);
    }


}
