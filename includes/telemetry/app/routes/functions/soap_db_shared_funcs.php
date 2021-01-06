<?php
/**
 * @author P2508450
 * shared functions used within routes go here
 */


use Doctrine\DBAL\DriverManager;

/**
 * Downloads messages from SOAP server
 * @param $app
 * @return mixed
 */
function getMessages($app)
{
    $messages_result = [];
    $soap_wrapper = $app->getContainer()->get('soapWrapper');
    $messages_model = $app->getContainer()->get('downloadMessagesModel');

    $messages_model->setSoapWrapper($soap_wrapper);
    $messages_model->performMessagesRetrieval(WSDL);
    return $messages_model->getResult();
}

/**
 * Iterates through downloaded data and parses xml string
 * @param $app
 * @param $downloaded_data data downloaded from SOAP server
 * @return array or parsed messages
 */
function parseDownloadedArray($app, $downloaded_data)
{
    $array_of_parsed_results = [];
    $xml_parser = $app->getContainer()->get('xmlParser');
    foreach ($downloaded_data as $downloaded_datum) {
        $xml_parser->setXmlStringToParse($downloaded_datum);
        $xml_parser->parseTheXmlString();
        $parsed_result = $xml_parser->getParsedData();
        $array_of_parsed_results[] = $parsed_result;
        $xml_parser->resetXmlParser();
    }
    return $array_of_parsed_results;
}

/**
 * @param $app
 * @param $tainted_messages array of parsed but unsanitized messages
 * @return array of checked messages
 */
function validateParsedMessages($app, $tainted_messages)
{
    $cleaned_messages = [];
    $validator = $app->getContainer()->get('validator');
    $cleaned_messages = $validator->validatemessages($tainted_messages, DEVICE_ID);
    return $cleaned_messages;
}

/**
 * Stores validated messages in the SQL database
 * @param $app
 * @param $cleaned_parameters
 * @return array
 * @throws \Doctrine\DBAL\Exception
 */
function storeValidatedMessages($app, $cleaned_parameters)
{
    $storage_result = [];
    $store_result = '';

    $database_connection_settings = $app->getContainer()->get('doctrine_settings');
    $doctrine_queries = $app->getContainer()->get('doctrineSqlQueries');
    $database_connection = DriverManager::getConnection($database_connection_settings);

    $query_builder = $database_connection->createQueryBuilder();
    $storage_results = $doctrine_queries::queryStoreMessages($query_builder, $cleaned_parameters);
    $result_outcomes = [];

    //storage results returned in array. Check each outcome to see if successful
    foreach ($storage_results as $storage_result) {
        if ($storage_result['outcome'] == 1) {
            $result_outcomes[] = 'User data was successfully stored using the SQL query: ' . $storage_result['sql_query'];
        } else {
            $result_outcomes[] = 'There appears to have been a problem when saving your details.  Please try again later.';
        }
    }
    return $result_outcomes;
}