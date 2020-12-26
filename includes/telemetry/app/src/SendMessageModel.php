<?php
/**
 *SendMessageModel
 *
 * Model used to send messages via SOAP call
 * @author P2508450
 */

namespace Telemetry;

class SendMessageModel
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

    /**
     * sets soapWrapper
     * @param $soap_wrapper
     */
    public function setSoapWrapper($soap_wrapper)
    {
        $this->soap_wrapper = $soap_wrapper;
    }

    /**
     * performs soap call to send message using soap wrapper
     * @param $destination_msdisn
     * @param $message
     * @param $wsdl
     */
    public function performSendMessage($destination_msdisn, $message)
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

    /**
     * returns result of message send
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
}