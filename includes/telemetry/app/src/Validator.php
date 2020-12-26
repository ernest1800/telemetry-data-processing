<?php
/**
 * Validator
 *
 * This class is responsible for validating data
 * Data downloaded from the soap server is checked to make sure it is from a registered device
 * Data downloaded is sanitized and validated and valid associated array is returned
 *
 * @author P2508450
 */

namespace Telemetry;

class Validator
{
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * checks if the device ID is ours
     */
    public function checkDeviceID($device_id_to_check, $d_id)
    {
        return ($device_id_to_check == $d_id);

    }

    /**
     * Validates array of tainted messages
     * @param $tainted_messages array
     * @return array of validated messaged
     */
    public function validateMessages($tainted_messages, $d_id)
    {
        $cleaned_messages = [];
        foreach ($tainted_messages as $tainted_message) {
            $cleaned_message = $this->validateMessage($tainted_message);
            //check if message sent from our device
            if (isset($cleaned_message['D_ID'])) {
                if ($this->checkDeviceID($cleaned_message['D_ID'], $d_id)) {
                    $cleaned_messages[] = $cleaned_message;
                }
            }
        }
        return $cleaned_messages;
    }

    /**
     * This method validates a single parsed message and returns a santitized array of values
     * @param $tainted_message
     * @return array of checked values against arguments
     */
    private function validateMessage($tainted_message)
    {
        $cleaned_message = [];
        $args_meta = [
            'SOURCEMSISDN' => FILTER_SANITIZE_STRING,
            'DESTINATIONMSISDN' => FILTER_SANITIZE_STRING,
            'RECEIVEDTIME' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => [
                    'regexp' => '~^\d{2}\/\d{2}\/\d{4}\040\d{2}\:\d{2}\:\d{2}$~'
                ]],
            'BEARER' => FILTER_SANITIZE_STRING,
            'MESSAGEREF' => FILTER_VALIDATE_INT,
            'D_ID' => FILTER_SANITIZE_STRING,
        ];

        $args =  $args_meta + $this->messageArgs();

        $checked_value = filter_var_array($tainted_message, $args);
        if (!(
            in_array(null, $checked_value, true) ||
            in_array(false, $checked_value, true) ||
            in_array(-1, $checked_value
            ))) {
            $cleaned_message = $checked_value;
        }

        return $cleaned_message;
    }

    /**
     * This method validates data passed from the sendsettings form to be sent as a message to the soap server
     * @param $tainted_settings
     * @return array|mixed
     */
    public function validateSettingsData($tainted_settings)
    {
        $cleaned_settings = [];
        $args = $this->messageArgs();

        $checked_value = filter_var_array($tainted_settings, $args);
        if (!(
            in_array(null, $checked_value, true) ||
            in_array(false, $checked_value, true) ||
            in_array(-1, $checked_value
            ))) {
            $cleaned_settings = $checked_value;
        }

        return $cleaned_settings;

    }

    /**
     * standardized arguments for validating messages before adding to Db and also before
     * sending new settings to SOAP server.
     * No device ID is checked as when sending settigns to soap server the device ID is appended onto the array if this
     * function returns valid
     */
    private function messageArgs()
    {
        $args = [
            'A' => ['filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'default' => -1,
                    'min_range' => 0,
                    'max_range' => 1
                ]
            ],
            'B' => ['filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'default' => -1,
                    'min_range' => 0,
                    'max_range' => 1
                ]
            ],
            'C' => ['filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'default' => -1,
                    'min_range' => 0,
                    'max_range' => 1
                ]
            ],
            'D' => ['filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'default' => -1,
                    'min_range' => 0,
                    'max_range' => 1
                ]
            ],
            'FAN' => ['filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'default' => -1,
                    'min_range' => 0,
                    'max_range' => 1
                ]],
            'H_TEMP' => ['filter' => FILTER_VALIDATE_FLOAT,
                'options' => [
                    'default' => -1,
                    'min_range' => -280,
                    'max_range' => 99999
                ]
            ],
            'KEY' => FILTER_VALIDATE_INT,
        ];
        return $args;
    }

}