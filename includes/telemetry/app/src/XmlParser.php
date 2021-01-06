<?php
/**
 * class XmlParser
 *
 * Parses a given XML string and returns an associative array
 *
 * Modified by P2508450
 * @author CF Ingrams - cfi@dmu.ac.uk
 * @copyright De Montfort University
 */

namespace Telemetry;

class XmlParser
{
    private $xml_parser;                              // handle to instance of the XML parser
    private $parsed_data;              // array holds extracted data
    private $element_name;                // store the current element name
    private $temporary_attributes;    // temporarily store tag attributes and values
    private $xml_string_to_parse;

    public function __construct()
    {
        $this->parsed_data = [];
        $this->temporary_attributes = [];
    }

    // release retained memory
    public function __destruct()
    {
        if ($this->xml_parser != null) {
            xml_parser_free($this->xml_parser);
        }
    }

    /**
     * resets properties so that new xml string can be parsed
     */
    public function resetXmlParser()
    {
        $this->xml_parser_string_to_parse = null;
        $this->xml_parser = null;
        $this->element_name = null;
        $this->temporary_attributes = [];
        $this->parsed_data = [];
    }

    /**
     * @param $xml_string_to_parse - sets xml string to be parsed
     */
    public function setXmlStringToParse($xml_string_to_parse)
    {
        $this->xml_string_to_parse = $xml_string_to_parse;
    }

    /**
     * @return array - of all parsed data stored
     */
    public function getParsedData()
    {
        return $this->parsed_data;
    }

    /**
     *  parses xml string and stores it in property
     */
    public function parseTheXmlString()
    {
        $this->xml_parser = xml_parser_create();

        xml_set_object($this->xml_parser, $this);

        // assign functions to be called when a new element is entered and exited
        xml_set_element_handler($this->xml_parser, "open_element", "close_element");

        // assign the function to be used when an element contains data
        xml_set_character_data_handler($this->xml_parser, "process_element_data");

        $this->parseTheDataString();
    }


    /**
     * parse xml data into data structure key value array
     */
    private function parseTheDataString()
    {
        xml_parse($this->xml_parser, $this->xml_string_to_parse);
    }

    /**
     * process an open element event & store the tag name
     * extract the attribute names and values, if any
     * @param $parser
     * @param $element_name
     * @param $attributes
     */
    private function open_element($parser, $element_name, $attributes)
    {
        $this->element_name = $element_name;
        if (sizeof($attributes) > 0) {
            foreach ($attributes as $att_name => $att_value) {
                $tag_att = $element_name . "." . $att_name;
                $this->temporary_attributes[$tag_att] = $att_value;
            }
        }
    }

    /**
     * process data from an element
     * @param $parser
     * @param $element_data
     */
    private function process_element_data($parser, $element_data)
    {
        if (array_key_exists($this->element_name, $this->parsed_data) === false) {
            $this->parsed_data[$this->element_name] = $element_data;
            if (sizeof($this->temporary_attributes) > 0) {
                foreach ($this->temporary_attributes as $tag_att_name => $tag_att_value) {
                    $this->parsed_data[$tag_att_name] = $tag_att_value;
                }
            }
        }
    }

    /**
     * process a close element event
     * @param $parser
     * @param $element_name
     */
    private function close_element($parser, $element_name)
    {
        // do nothing here
    }
}