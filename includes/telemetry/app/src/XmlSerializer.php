<?php
/**
 * class for formatting messages to be sent to the SOAP server
 * Converts validated associative array to an XML style string
 */

namespace Telemetry;


class XmlSerializer
{

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * Creates opening and closing xml tags from assoc array key
     * @param $key
     * @return array
     */
    private function createTags($key)
    {
        $tags = [];
        $tags[0] = '<' . $key . '>';
        $tags[1] = '</' . $key . '>';
        return $tags;

    }

    /**
     * converts assoc array to xml string format so that it can be sent as a correctly formatted message to server
     * array keys are tag names and values are values
     * @param $array
     * @return string
     */
    public function serializeArrayToXml($array)
    {
        //TODO add check
        $xml_string = "";
        foreach ($array as $key => $value) {
            $tags = $this->createTags($key);
            $xml_string .= $tags[0] . $value . $tags[1];
        }
        return $xml_string;
    }
}