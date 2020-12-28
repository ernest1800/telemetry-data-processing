<?php
/**
 * displaymessages.php
 *
 * This route displays a history of all messages sent from the team's device.
 *
 * @author P2508450
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Doctrine\DBAL\DriverManager;


$app->get('/displaymessages', function (Request $request, Response $response) use ($app) {
    $sid = session_id();

    $error_text = "";
    //instantiate logger

    $l = $app->getContainer()->get("monologWrapper");
    $l->storeLog("SYM 1234567");

    //parameters from the GET call
    $tainted_parameters = $request->getParsedBody();

    $tainted_data = getMessages($app);
    //TODO check length and continue if length > 0 else display info
    //parse downloaded data
    $parsed_data = parseDownloadedArray($app, $tainted_data);
    //validate parsed data

    $validated_data = validateParsedMessages($app, $parsed_data);

    //here we have all data from soap
        //download data from db
        //check if messages match
        //save to db
        //download new data from db

    //send validated data to db
    $storage_result = storeValidatedMessages($app, $validated_data);

    //get data from DB
    $data_from_db = retrieveMessages($app);


    //if no data received then display warning in error text;
    if(count($data_from_db) < 1){
        $error_text = "No telemetry data found in database";
    }


    sendConfirmationMessage($app);

    $html_output = $this->view->render($response,
        'displaymessages.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'action' => 'loadmessages',
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Telemetry Messages',
            'button_text_back' => 'Back',
            'home_page' => 'home',
            'messages_DB' => $data_from_db,
            'table_headers' => [
                "SOURCE",
                "DEST",
                "TIME RECEIVED",
                "BEARER",
                "DEVICE ID",
                "SWITCH A",
                "SWITCH B",
                "SWITCH C",
                "SWITCH D",
                "FAN",
                "TEMP",
                "KEY",
            ],
            'text_switch_on' => "ON",
            'text_switch_off' => "OFF",
            'text_fan_fwd' => "FWD",
            'text_fan_rev' => "REV",
            'text_error' => $error_text,
        ]);

    processOutput($app, $html_output);

    return $html_output;

})->setName('displaymessages');

/**
 * @param $app
 *
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
 * iterates through downloaded data and parses xml string
 * @param $app
 * @param $downloaded_data data downloaded from SOAP server
 * @return array or parsed messages
 */
function parseDownloadedArray($app, $downloaded_data)
{
    $array_of_parsed_results = [];
    $xml_parser = $app->getContainer()->get('xmlParser');
    //TODO check length return false if < 0
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

/**
 * Retrieve stored messages from database
 * @param $app
 * @return mixed - result from SQL query
 * @throws \Doctrine\DBAL\Exception
 */
function retrieveMessages($app)
{
    $retrieve_result = [];

    $database_connection_settings = $app->getContainer()->get('doctrine_settings');
    $doctrine_queries = $app->getContainer()->get('doctrineSqlQueries');
    $database_connection = DriverManager::getConnection($database_connection_settings);

    $query_builder = $database_connection->createQueryBuilder();
    $retrieve_result = $doctrine_queries::queryRetrieveMessages($query_builder);

    return $retrieve_result;
}

/**
 * Send a confirmation message via soap call to send message method
 * @param $app
 */
function sendConfirmationMessage($app)
{
    $soap_wrapper = $app->getContainer()->get('soapWrapper');
    $message_model = $app->getContainer()->get('sendMessageModel');

    $message_model->setSoapWrapper($soap_wrapper);
    $message_model->performSendMessage(DEST_MSISDN, "Test message sent from SLIM");

    return $message_model->getResult();

}



