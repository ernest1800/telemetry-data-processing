<?php

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig'],
        [
            'debug' => true // This line should enable debug mode
        ]
    );

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['processOutput'] = function ($container) {
    $model = new \Telemetry\ProcessOutput();
    return $model;
};

$container['xmlParser'] = function ($container) {
    $model = new \Telemetry\XmlParser();
    return $model;
};

$container['xmlSerializer'] = function ($container) {
    $model = new \Telemetry\XmlSerializer();
    return $model;
};

$container['validator'] = function ($container) {
    $validator = new \Telemetry\Validator();
    return $validator;
};

$container['soapWrapper'] = function ($container) {
    $validator = new \Telemetry\SoapWrapper();
    return $validator;
};

$container['monologWrapper'] = function ($container) {
    $wrapper = new \Telemetry\MonologWrapper();
    return $wrapper;
};

$container['downloadMessagesModel'] = function ($container) {
    $model = new \Telemetry\DownloadMessagesModel();
    return $model;
};

$container['sendMessageModel'] = function ($container) {
    $model = new \Telemetry\SendMessageModel();
    return $model;
};

$container['doctrineSqlQueries'] = function ($container) {
    $doctrine_sql_queries = new \Telemetry\DoctrineSqlQueries();
    return $doctrine_sql_queries;
};

$container['messageFormatter'] = function ($container) {
    $message_formatter = new \Telemetry\MessageFormatter();
    return $message_formatter;
};

