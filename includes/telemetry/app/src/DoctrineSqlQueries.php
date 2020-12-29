<?php
/**
 * class to contain all database access using Doctrine's QueryBulder
 *
 * A QueryBuilder provides an API that is designed for conditionally constructing a DQL query in several steps.
 *
 * It provides a set of classes and methods that is able to programmatically build queries, and also provides
 * a fluent API.
 * This means that you can change between one methodology to the other as you want, or just pick a preferred one.
 *
 * @author P2508450
 *
 * From https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html
 */

namespace Telemetry;

class DoctrineSqlQueries
{
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * takes array of messages as parameters. Saves each message to DB
     * @param $query_builder
     * @param array $cleaned_parameters
     * @return array of results from query
     */
    public static function queryStoreMessages($query_builder, array $cleaned_array_of_messages)
    {

        //retrieve messages in database so that we can check if the message we intend to store already exists
        $messages_from_db = self::queryRetrieveMessages($query_builder);

        $store_results = [];
        foreach ($cleaned_array_of_messages as $cleaned_message) {
            //$store_result = self::queryStoreMessage($query_builder, $cleaned_message);
            $store_result = self::queryStoreMessageIfNotExists($query_builder, $cleaned_message, $messages_from_db);

            //if message does not already exist in db then add to array
            if ($store_result != false) {
                $store_results[] = $store_result;
            }
        }
        return $store_results;
    }

    /**
     * Stores mesasge from soap server in database if message does not already exist to
     * stop dupicate records being stored
     * @param $query_builder
     * @param $cleaned_message
     * @return array|bool
     */
    private static function queryStoreMessageIfNotExists($query_builder, $cleaned_message, $messages_in_db)
    {
        //if message with that timestamp already exists then return false
        foreach ($messages_in_db as $message_in_db){
            if($message_in_db["received_time"] == $cleaned_message["RECEIVEDTIME"]){
                return false;
            }
        }

        $store_result = [];
        $source_msisdn = $cleaned_message['SOURCEMSISDN'];
        $dest_msisdn = $cleaned_message['DESTINATIONMSISDN'];
        $bearer = $cleaned_message['BEARER'];
        $message_ref = $cleaned_message['MESSAGEREF'];
        $received_time = $cleaned_message['RECEIVEDTIME'];
        $device_id = $cleaned_message['D_ID'];
        $switch_a = $cleaned_message['A'];
        $switch_b = $cleaned_message['B'];
        $switch_c = $cleaned_message['C'];
        $switch_d = $cleaned_message['D'];
        $fan = $cleaned_message['FAN'];
        $h_temp = $cleaned_message['H_TEMP'];
        $last_key = $cleaned_message['KEY'];


        $query_builder = $query_builder->insert('messages')
            ->values([
                'source_msisdn' => ':source_msisdn',
                'dest_msisdn' => ':dest_msisdn',
                'bearer' => ':bearer',
                'message_ref' => ':message_ref',
                'received_time' => ':received_time',
                'device_id' => ':device_id',
                'switch_a' => ':switch_a',
                'switch_b' => ':switch_b',
                'switch_c' => ':switch_c',
                'switch_d' => ':switch_d',
                'fan' => ':fan',
                'h_temp' => ':h_temp',
                'last_key' => ':last_key',
            ])
            ->setParameters([
                'source_msisdn' => $source_msisdn,
                'dest_msisdn' => $dest_msisdn,
                'bearer' => $bearer,
                'message_ref' => $message_ref,
                'received_time' => $received_time,
                'device_id' => $device_id,
                'switch_a' => $switch_a,
                'switch_b' => $switch_b,
                'switch_c' => $switch_c,
                'switch_d' => $switch_d,
                'fan' => $fan,
                'h_temp' => $h_temp,
                'last_key' => $last_key,
            ]);

        $store_result['outcome'] = $query_builder->execute();
        $store_result['sql_query'] = $query_builder->getSQL();

        return $store_result;
    }

    /**
     * Fetch all records from messages table
     * @param $query_builder
     * @return array of messages
     */
    public static function queryRetrieveMessages($query_builder)
    {
        $result = [];
        $query_builder
            ->select('*')
            ->from('messages', 'u');
        $query = $query_builder->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
