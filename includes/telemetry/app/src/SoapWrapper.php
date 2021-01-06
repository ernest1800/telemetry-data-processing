<?php
/**
 * SoapWrapper
 * Provides a handle for accessing soap server calls
 *
 * @author P2508450
 */

namespace Telemetry;

use phpDocumentor\Reflection\Types\Integer;

class SoapWrapper
{
    private $wsdl;

    public function __construct()
    {
        if (defined('WSDL')) {
            $this->wsdl = WSDL;
        } else {
            $this->wsdl = "";
        }

    }

    public function __destruct()
    {
    }

    /**
     * @param $wsdl sets wsdl string for class
     */
    public function setWsdl($wsdl)
    {
        $this->wsdl = $wsdl;
    }

    /**
     * Creates a soap client halndel and returns it for use
     * @return \SoapClient|string
     */
    public function createSoapClient()
    {
        $soap_client_handle = false;
        $soap_client_parameters = array();
        $exception = '';

        $soap_client_parameters = ['trace' => true, 'exceptions' => true];

        try {
            $soap_client_handle = new \SoapClient($this->wsdl, $soap_client_parameters);
        } catch (\SoapFault $exception) {
            $soap_client_handle = 'Ooops - something went wrong when connecting to the data supplier.  Please try again later';
        }
        return $soap_client_handle;
    }

    /**
     * Reads messages from server using peekMessages.
     * @param $soap_client
     * @return \Exception|\SoapFault|array Returns array if soap call is successful
     */
    public function performSoapCallPeek($soap_client)
    {
        $soap_call_result = null;

        if ($soap_client) {
            try {
                $webservice_call_result = $soap_client->peekMessages("20_2508450", "PapaJohn1234", 100, 447817814149, 44);
                if ($webservice_call_result) {
                    $soap_call_result = $webservice_call_result;
                }
            } catch (\SoapFault $exception) {
                $soap_call_result = $exception;
            }
        }
        return $soap_call_result;
    }

    /**
     * Sends sms message via soap call
     * @param $soap_client
     * @param int $destination_msisdn
     * @param string $message
     * @return \Exception|\SoapFault|null
     */
    public function performSoapCallSend($soap_client, int $destination_msisdn, string $message)
    {
        $soap_call_result = null;

        if ($soap_client) {
            try {
                $webservice_call_result = $soap_client->sendMessage(
                    "20_2508450",                                    //m2m user
                    "PapaJohn1234",                                  // m2m password
                    $destination_msisdn,                             //recipient
                    html_entity_decode($message),              //message
                    '',                                           //delivery report
                    "SMS"                                            //bearer
                );
                if ($webservice_call_result) {
                    $soap_call_result = $webservice_call_result;
                }
            } catch (\SoapFault $exception) {
                $soap_call_result = $exception;
            }
        }
        return $soap_call_result;

    }
}