<?php

namespace Telemetry;

use PHPUnit\Framework\TestCase;

class SendMessageModelTest extends TestCase
{
    protected $wsdl = 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';
    public function testSendMessage()
    {
        $expected_result = 397;
        $soap_wrapper = new SoapWrapper();
        $soap_wrapper->setWsdl($this->wsdl);

        $message_model = new SendMessageModel();
        $message_model->setSoapWrapper($soap_wrapper);

        $message = "Test message sent from SLIM";
        $destination = 447817814149;
        $message_model->performSendMessage($destination, $message);

        //soap sendMessage method returns integer when message successfully sent
        $this->assertIsInt($message_model->getResult());
    }
}
