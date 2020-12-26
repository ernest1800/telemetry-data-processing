<?php
/**
 * class for formatting messages to be sent to the SOAP server
 */

namespace Telemetry;


class MessageFormatter
{

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * adds device id item to beginning of settings array
     * @param $settings
     * @param $device_id
     * @return array
     */
    public function addDeviceIdToSettings($settings, $device_id)
    {
        $new_settings = array_merge(["D_ID" => $device_id], $settings);
        return $new_settings;
    }
}