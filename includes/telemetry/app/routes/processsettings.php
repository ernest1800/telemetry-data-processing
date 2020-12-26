<?php
/**
 * sendsettings.php
 *
 * the route for sending telemetry settings back to the device
 *
 * @author P2508450
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//closure so route can have multiple names
$send_settings = function(Request $request, Response $response) use ($app)
{

    $sid = session_id();

    $html_output = $this->view->render($response,
        'sendsettings.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'action' => 'loadmessages',
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'action' => 'processsettings',
            'method' => 'post',
            'device_id_text' => "Update settings for: ".DEVICE_ID,
            'label_text_a' => "Sensor A ON/OFF",
            'label_text_b' => "Sensor B ON/OFF",
            'label_text_c' => "Sensor C ON/OFF",
            'label_text_d' => "Sensor D ON/OFF",
            'label_text_fan' => "Fan FWD/REVERSE",
            'label_text_temp' => "Temp C",
            'label_text_key' => "Last Key",
            'button_text_send' => "Send Settings",
        ]);

    processOutput($app, $html_output);

    return $html_output;

};

$app->get('/sendsettings', $send_settings)->setName('home');

$app->post('/sendsettings', function (Request $request, Response $response) {
    var_dump($_POST);
    //get data from request

    //validate data
    //if good then send if not return error
});

