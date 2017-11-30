<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 01/08/17
 * Time: 11:07 PM
 */

namespace app\service;


class GovDataService
{

    static $URL = "https://data.gov.in/api/datastore/resource.json";
    static $API_KEY = null;
    static $BATCH_SIZE = 100;
    static $RESOURCE_PINCODE_DIR = "6176ee09-3d56-4a3b-8115-21841576b2f6";


    public static function configure()
    {
        $config = \Config::getSection("DATA_GOV_IN");
        self::$API_KEY = $config['API_KEY'];
    }


    public static function fetchPostOfficeByPincode($stateName, $offset = 0)
    {
        $result = json_decode(self::api(
            null,
            self::$URL,
            array(
                "resource_id" => self::$RESOURCE_PINCODE_DIR,
                "api-key" => self::$API_KEY,
                "limit" => self::$BATCH_SIZE,
                "filters" => array(
                    "pincode" => $stateName
                )
            )
        ));

        $records = $result->records;

        if (count($records) >= self::$BATCH_SIZE) {
            $records_more = self::fetchPostOfficeByPincode($stateName, ($offset + 1) * self::$BATCH_SIZE);
            return array_merge($records, $records_more);
        }
        return $records;
    }

    public static function api($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}

GovDataService::configure();