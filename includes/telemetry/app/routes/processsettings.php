<?php
/**
 * processsettings.php
 *
 * the route for sending telemetry settings back to the device
 * Displays error or confirmation message
 *
 * @author P2508450
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/processsettings', function (Request $request, Response $response) use ($app) {

    $l = $app->getContainer()->get("monologWrapper");
    $send_result = "";
    $again_text = "Try Again";

    $tainted_parameters = $request->getParsedBody();
    //validate data
    $cleaned_data = validateSettingsData($app, $tainted_parameters);
    //if good then send if not return error
    if (empty($cleaned_data)) {
        //go to error
        $send_result = "Error sending settings. Please check format is correct";
    } else {
        //add device ID to array
        $cleaned_data = addDeviceId($app, $cleaned_data);
        //to xml
        $serialized_data = serializeArrayToXml($app, $cleaned_data);
        //send message
        $result = sendSettingsMessage($app, $serialized_data);
        //if result is integer then message successfully sent
        if (is_integer($result)) {
            $send_result = "Setting successfully sent!";
            $again_text = "Update Settings Again";
            $l->storeLog("Settings sent to server");
        } else {
            $send_result = "Error. Message not sent. Please Try again";
            $l->storeLog("Settings failed to send");
        }
    }
    //display result
    $html_output = $this->view->render($response,
        'displaysendresult.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'initial_input_box_value' => null,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Result',
            'result_text' => $send_result,
            'button_text_home' => 'Return to Home',
            'home_page' => 'home',
            'button_text_again' => $again_text, // display "try again" if send failed. display "Update again" if success
            'send_page' => 'sendsettings',
        ]);
    return $html_output;
});

/**
 * validates request body from sendsettings form.
 * @param $app
 * @param $tainted_parameters
 * @return mixed
 */
function validateSettingsData($app, $tainted_parameters)
{
    $validator = $app->getContainer()->get('validator');
    $cleaned_data = $validator->validateSettingsData($tainted_parameters);
    return $cleaned_data;
}

/**
 * Adds device ID to beginning of settings array so that can be identified on SOAP server
 * @param $app
 * @param $cleaned_settings
 * @return mixed
 */
function addDeviceId($app, $cleaned_settings)
{
    $message_formatter = $app->getContainer()->get("messageFormatter");
    $new_settings = $message_formatter->addDeviceIdToSettings($cleaned_settings, DEVICE_ID);
    return $new_settings;
}

/**
 * Turns cleaned associative array into a correctly formatted xml string so it can be sent to SOAP server.
 */
function serializeArrayToXml($app, $cleaned_data)
{
    $xml_serializer = $app->getContainer()->get("xmlSerializer");
    $serialized_data = $xml_serializer->serializeArrayToXml($cleaned_data);
    //TODO add check
    return $serialized_data;
}


/**
 * Sends user specified settins to SOAP server via soap call for sendMessage SMS
 * @param $app
 * @param $settings
 * @return mixed
 */
function sendSettingsMessage($app, $settings)
{
    $soap_wrapper = $app->getContainer()->get('soapWrapper');
    $message_model = $app->getContainer()->get('sendMessageModel');

    $message_model->setSoapWrapper($soap_wrapper);
    $message_model->performSendMessage(DEST_MSISDN, $settings);

    return $message_model->getResult();

}
