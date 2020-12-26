<?php
 /**
  * DownloadMessagesModelTest
  */
namespace Telemetry;

use PHPUnit\Framework\TestCase;

class DownloadMessagesModelTest extends TestCase
{
    protected $wsdl = 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';

    /**
     *  Test if array is returned from SOAP server
     */
    public function testRetrieveMessages()
    {
        $soap_wrapper = new SoapWrapper();
        $soap_wrapper->setWsdl($this->wsdl);
        $message_model = new DownloadMessagesModel();
        $message_model->setSoapWrapper($soap_wrapper);
        $message_model->performMessagesRetrieval($this->wsdl);
        $result = $message_model->getResult();
        $this->assertIsArray($result);

    }
}
