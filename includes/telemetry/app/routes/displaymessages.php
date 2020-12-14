<?php
/**
 * displaymessages.php
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/displaymessages', function(Request $request, Response $response) use ($app)
{

    $sid = session_id();

    $html_output = $this->view->render($response,
        'displaymessages.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'action' => 'loadmessages',
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Telemetry Messages',
            'page_text_1' => 'This page should display messages from the SOAP server',
            'button_text_back' => 'Back',
            'home_page' => 'home',
        ]);

    processOutput($app, $html_output);

    return $html_output;

})->setName('displaymessages');

