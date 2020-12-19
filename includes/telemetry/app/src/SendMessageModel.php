<?php
/**
 *
 */

namespace Telemetry;

class SendMessagesModel
{
    private $result;
    private $soap_wrapper;

    public function __construct()
    {
        $this->soap_wrapper = null;
        $this->result = [];
    }

    public function __destruct()
    {
    }

    public function setSoapWrapper($soap_wrapper)
    {
        $this->soap_wrapper = $soap_wrapper;
    }

    public function performMessagesRetrieval($wsdl = null)
    {
        $soap_call_result = null;
        $soap_client_handle = $this->soap_wrapper->createSoapClient();

        // handle will be string if error is returned from createSoapClient
        if ($soap_client_handle !== false && !is_string($soap_client_handle)) {
            $soap_call_result = $this->soap_wrapper->performSoapCallPeek($soap_client_handle);

            $this->result = $soap_call_result;
        }
    }

    public function performSendMessage($destination_msdisn, $message, $wsdl = null)
    {
        $soap_call_result = null;
        $soap_client_handle = $this->soap_wrapper->createSoapClient();

        if ($soap_client_handle !== false && !is_string($soap_client_handle)) {
            $soap_call_result = $this->soap_wrapper->performSoapCallSend(
                $soap_client_handle,
                $destination_msdisn,
                $message
            );

            $this->result = $soap_call_result;
        }

    }

    public function getResult()
    {
        return $this->result;
    }
}