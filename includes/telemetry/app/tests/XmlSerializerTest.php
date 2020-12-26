<?php

namespace Telemetry;

use PHPUnit\Framework\TestCase;

class XmlSerializerTest extends TestCase
{
    protected $array_input = [
        'D_ID' => 'AF72',
        'A' => '1',
        'B' => '1',
        'C' => '1',
        'D' => '0',
        'FAN' => '0',
        'H_TEMP' => '12.0',
        'KEY' => '3',
    ];

    protected $expected_string_correct = "<D_ID>AF72</D_ID><A>1</A><B>1</B><C>1</C><D>0</D><FAN>0</FAN><H_TEMP>12.0</H_TEMP><KEY>3</KEY>";

    /**
     * Correct format of assoc array passed expect XML string back
     */
    public function testXmlSerializingCorrect()
    {
        $xml_serializer = new XmlSerializer();
        $serialized_xml = $xml_serializer->serializeArrayToXml($this->array_input);
        $this->assertEquals($this->expected_string_correct, $serialized_xml);
    }

}