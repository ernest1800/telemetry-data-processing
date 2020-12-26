<?php
/**
 * SoapWrapperTest
 */
namespace Telemetry;

use PHPUnit\Framework\TestCase;

class SoapWrapperTest extends TestCase
{
    protected $wsdl = 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl';

    /**
     * Test creation of soap client handle expect a Soapclient object to be returned
     */
    public function testCreateSoapClient()
    {
        $soap_wrapper = new SoapWrapper();
        $soap_wrapper->setWsdl($this->wsdl);
        $handle = $soap_wrapper->createSoapClient();
        $this->assertInstanceOf("SoapClient", $handle);
    }

    /**
     * Test error message, should return a string
     */
    public function testCreateSoapClientError()
    {
        $soap_wrapper = new SoapWrapper();
        $handle = $soap_wrapper->createSoapClient();
        $this->assertIsString($handle);
    }
}
