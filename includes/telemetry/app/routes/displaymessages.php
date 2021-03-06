<?php
/**
 * displaymessages.php
 *
 * This route displays a history of all messages sent from the team's device in tabualr format.
 *
 * @author P2508450
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Doctrine\DBAL\DriverManager;


$app->get('/displaymessages', function (Request $request, Response $response) use ($app) {
    require_once("utils/soap_db_shared_funcs.php");
    $sid = session_id();

    //instantiate logger
    $l = $app->getContainer()->get("monologWrapper");

    //download messages from server
    $tainted_data = getMessages($app);
    $l->storeLog("Message History Downloading");

    $storage_result = downloadAndStoreData($app);
    //get data from DB

    //log download result
    if($storage_result){
        $l->storeLog("Messages downloaded from server and stored in DB");
    }else{
        $l->storeLog("No messages found on soap server");
    }

    $data_from_db = retrieveMessages($app);

    $error_text = "";
    //if no data received then display warning in error text;
    if(count($data_from_db) < 1){
        $error_text = "No telemetry data found in database";
    }else {
        $l->storeLog("Messages Stored");
    }

    $html_output = $this->view->render($response,
        'displaymessages.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'action' => 'loadmessages',
            'page_title' => APP_NAME,
            'nav_links' => NAV_LINKS,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Telemetry Messages',
            'nav_links' => NAV_LINKS,
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

    return $html_output;

})->setName('displaymessages');


/**
 * Send a confirmation message via soap call to send message method
 * @param $app
 */
function sendConfirmationMessage($app)
{
    $soap_wrapper = $app->getContainer()->get('soapWrapper');
    $message_model = $app->getContainer()->get('sendMessageModel');

    $message_model->setSoapWrapper($soap_wrapper);
    $message_model->performSendMessage(DEST_MSISDN, "New message received from " + DEVICE_ID);

    return $message_model->getResult();

}



