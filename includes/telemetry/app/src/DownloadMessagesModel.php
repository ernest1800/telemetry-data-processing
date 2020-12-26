<?php
/**
 * DownloadMessagesModel
 *
 * Class used for downloading messages from SOAP server via SOAP call
 *
 * @author P2508450
 */

namespace Telemetry;

class DownloadMessagesModel
{
    private $result;
    private $soap_wrapper;

    public function __construct()
    {
        $this->soap_wrapper = null;
        $this->result = [];
    }

    public function __destruct(){}

    /**
     * sets soap_wrapper
     * @param $soap_wrapper
     */
    public function setSoapWrapper($soap_wrapper)
    {
        $this->soap_wrapper = $soap_wrapper;
    }

    /**
     * Retrieves all messages stored on soap server and stores returned array in soap_call_result
     * @param $wsdl
     */
    public function performMessagesRetrieval($wsdl)
    {
        $soap_call_result = null;
        $soap_client_handle = $this->soap_wrapper->createSoapClient();

        // handle will be string if error is returned from createSoapClient
        if ($soap_client_handle !== false && ! is_string($soap_client_handle))
        {
            $soap_call_result = $this->soap_wrapper->performSoapCallPeek($soap_client_handle);
            $this->result = $soap_call_result;
        }
    }

    /**
     * returns results array from retrieve messages call
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
}