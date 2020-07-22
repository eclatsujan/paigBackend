<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class PaigAPI
{
    /**
     * @var \Laravel\Lumen\Application
     */
    private $property_db;

    public function __construct(DB $db)
    {
        $this->property_db=$db;
    }

    public function getServerAPI($page_number)
    {
        set_time_limit(240);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://paighub.paig.com.au/backend/paig_api/all_sale_property");
        curl_setopt($ch, CURLOPT_POST, 1);

        // In real life you should use something like:
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            http_build_query(array('key' => 'dd1erz152es4fgztr1343sdvqq', 'page_size' => 100, 'page_number' => $page_number)));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        return json_decode($server_output, true);
    }

    public function getSingleServerAPI(){

    }


    //Single Sql
    public function insertOrUpdate(array $rows){

        $table="properties";

        $first = reset($rows);

        $columns = implode( ',',
            array_map( function( $value ) { return "$value"; } , array_keys($first) )
        );

        $values = implode( ',', array_map( function( $row ) {
                return '('.implode( ',',
                        array_map( function( $value ) { return '"'.str_replace('"', '""', $value).'"'; } , $row )
                    ).')';
            } , $rows )
        );

        $updates = implode( ',',
            array_map( function( $value ) { return "$value = VALUES($value)"; } , array_keys($first) )
        );

        $sql = "INSERT INTO {$table}({$columns}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updates}";

        return $this->property_db->statement( $sql );
    }

    public function setDB($response)
    {
        if ($response["status"] === true) {
            foreach ($response["data"] as $property) {
                unset($property["id"]);
                if(isset($property["attachments"])){
                    $property["attachments"] = serialize($property["attachments"]);
                }
                $property["property_id"] = (int)$property["property_id"];
                $property["price"] = (double)$property["price"];
                $property["to_price"] = (double)$property["to_price"];
                $property["from_price"] = (double)$property["from_price"];
                $property["property_id"] = (int)$property["property_id"];
                $property["parent_property_id"] = (int)$property["parent_property_id"];
                $property["display_id"] = (int)$property["display_id"];

                app('db')->table('properties')
                    ->updateOrInsert(['property_id' => $property["property_id"]], $property);
            }
        }
    }

    public function getPropertyListings($page_number)
    {
        $response = $this->getServerAPI($page_number);
        $this->setDB($response);
        return ['page_number' => $response["page_number"], 'page_total' => $response["page_total"]];
    }

}
