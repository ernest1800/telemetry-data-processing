<?php
/**
 * home.php
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//closure so route can have multiple names
$home = function(Request $request, Response $response) use ($app)
{

    $sid = session_id();

    $html_output = $this->view->render($response,
        'home.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'action' => 'loadmessages',
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Telemetry Homepage',
            'button_text_load' => 'Load Messages M2M',
            'load_messages_page' => 'displaymessages'
        ]);

    processOutput($app, $html_output);

    return $html_output;

};

$app->get('/', $home)->setName('home');
$app->get('/home', $home)->setName('home');

function processOutput($app, $html_output)
{
    $process_output = $app->getContainer()->get('processOutput');
    $html_output = $process_output->processOutput($html_output);
    return $html_output;
}
