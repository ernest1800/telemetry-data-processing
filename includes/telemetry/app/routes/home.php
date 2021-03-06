<?php
/**
 * home.php
 *
 * route for homepage with links to other pages
 *
 * @author P2508450
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//closure so route can have multiple names
$home = function (Request $request, Response $response) use ($app) {
    $l = $app->getContainer()->get("monologWrapper");
    $l->storeLog("Home Accessed");

    $html_output = $this->view->render($response,
        'home.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'action' => 'loadmessages',
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Telemetry Homepage',
            'nav_links' => NAV_LINKS,
            'button_text_view' => 'View Telemetry',
            'button_text_load' => 'View History',
            'button_text_send' => 'Send New Settings',
            'view_settings_page' => 'viewsettings',
            'load_messages_page' => 'displaymessages',
            'send_settings_page' => 'sendsettings',
            'home_message' => 'Telemetry Options'

        ]);

    return $html_output;

};

$app->get('/', $home)->setName('home');
$app->get('/home', $home)->setName('home');

