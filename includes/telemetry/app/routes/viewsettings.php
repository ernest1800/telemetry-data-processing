<?php
/**
 * viewsettings.php
 *
 * This route displays the most recent telemetry settings. (The current state of the circuit board)
 *
 * @author P2508450
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


//closure so route can have multiple names
$view_settings = function (Request $request, Response $response) use ($app) {
    $current_settings = [];
    $sid = session_id();
    //get data from DB
    $data_from_db = retrieveMessages($app);

    if ($data_from_db) {
        $current_settings = getCurrentSettings($data_from_db);
    }

    $chart_location = generateChart($app);

    $html_output = $this->view->render($response,
        'viewsettings.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'action' => 'loadmessages',
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Telemetry Homepage',
            'button_text_back' => 'Back',
            'home_page' => 'home',
            'current_settings' => $current_settings,
            'thead_1' => 'Setting Name',
            'thead_2' => 'Reading',
            'chart_location' => $chart_location,

        ]);

    processOutput($app, $html_output);

    return $html_output;

};

$app->get('/viewsettings', $view_settings)->setName('viewsettings');

/**
 * Takes contents of messages table as a parameter then returns latest entry in array
 * @param $messages_array
 */
function getCurrentSettings($messages_array)
{
    return end($messages_array);
}


//TODO add to model
function generateChart($app)
{
    $settings_chart_model = $app->getContainer()->get("settingsChartModel");
    $settings_chart_model->createSettingsChart();
    $chart_location = $settings_chart_model->getChartLocation();
    return $chart_location;
}