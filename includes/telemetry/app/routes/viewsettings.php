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
    $sid = session_id();

    //get data from DB
    $data_from_db = retrieveMessages($app);

    //get latest message from array
    $error_text = "";
    $current_settings = [];
    if (count($data_from_db) > 1) {
        $current_settings = getCurrentSettings($data_from_db);
    }else{
        $error_text = "No telemetry data found!";
    }

    $chart_location = generateChart($app, $current_settings);

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
            'text_error' => $error_text,

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
function generateChart($app, $current_settings)
{
    $temperature = 0;
    if(isset($current_settings["h_temp"])){
        $temperature = $current_settings["h_temp"];
    }
    $settings_chart_model = $app->getContainer()->get("settingsChartModel");
    $settings_chart_model->createSettingsChart($temperature);
    $chart_location = $settings_chart_model->getChartLocation();
    return $chart_location;
}