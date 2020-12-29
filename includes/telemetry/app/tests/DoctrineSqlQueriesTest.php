<?php

namespace Telemetry;

use Doctrine\DBAL\DriverManager;
use PHPUnit\Framework\TestCase;

class DoctrineSqlQueriesTest extends TestCase
{

    protected $doctrine_settings = [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'dbname' => 'telemetry_db',
        'port' => '3306',
        'user' => 'telemetry_user',
        'password' => 'telemetry_user_pass',
        'charset' => 'utf8mb4'
    ];

    protected $cleaned_messages = [
        [
            'SOURCEMSISDN' => '447817814149',
            'DESTINATIONMSISDN' => '447817814149',
            'RECEIVEDTIME' => '14/12/2020 20:26:45',
            'BEARER' => 'SMS',
            'MESSAGEREF' => '0',
            'D_ID' => 'AF72',
            'A' => '1',
            'B' => '1',
            'C' => '1',
            'D' => '0',
            'FAN' => '0',
            'H_TEMP' => '55.0',
            'KEY' => '3',
        ]
        ,
        [
            'SOURCEMSISDN' => '447817814149',
            'DESTINATIONMSISDN' => '447817814149',
            'RECEIVEDTIME' => '14/12/2020 20:26:45',
            'BEARER' => 'SMS',
            'MESSAGEREF' => '0',
            'D_ID' => 'AF72',
            'A' => '1',
            'B' => '1',
            'C' => '1',
            'D' => '0',
            'FAN' => '0',
            'H_TEMP' => '56.0',
            'KEY' => '3',
        ]
    ];

    public function testStoreMessage()
    {
        $doctrineQueries = new DoctrineSqlQueries();

        $database_connection_settings = $this->doctrine_settings;
        $doctrine_queries = new DoctrineSqlQueries();
        $database_connection = DriverManager::getConnection($database_connection_settings);

        $query_builder = $database_connection->createQueryBuilder();
        $storage_result = $doctrine_queries::queryStoreMessages($query_builder, $this->cleaned_messages);

        $result_outcomes = [];
        $this->assertEquals([], $storage_result);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * Test to see if returning array of arrays from db
     */
    public function testRetrieveMessages()
    {
        $doctrineQueries = new DoctrineSqlQueries();

        $database_connection_settings = $this->doctrine_settings;
        $doctrine_queries = new DoctrineSqlQueries();
        $database_connection = DriverManager::getConnection($database_connection_settings);

        $query_builder = $database_connection->createQueryBuilder();
        $retrieve_result = $doctrine_queries::queryRetrieveMessages($query_builder);

        $this->assertIsArray($retrieve_result[0]);
    }

}
