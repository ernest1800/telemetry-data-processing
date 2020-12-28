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
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'action' => 'processsettings',
            'method' => 'post',
            'device_id_text' => "Update settings for: ".DEVICE_ID,
            'label_text_a' => "Switch A",
            'label_text_b' => "Switch B",
            'label_text_c' => "Switch C",
            'label_text_d' => "Switch D",
            'label_text_switch_on' => "ON",
            'label_text_switch_off' => "OFF",
            'label_text_fan' => "Fan",
            'label_text_fan_fwd' => "Forward",
            'label_text_fan_rev' => "Reverse",
            'label_text_temp' => "Temp C",
            'label_text_key' => "Last Key",
            'button_text_send' => "Send Settings",
        ]);

    processOutput($app, $html_output);

    return $html_output;

};

$app->get('/sendsettings', $send_settings)->setName('sendsettings');

