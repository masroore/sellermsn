<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 01/08/17
 * Time: 11:07 PM
 */

namespace app\service;


class RazorPayService extends BasicService
{

    static $URL = "https://ifsc.razorpay.com";
    static $API_KEY = null;

    public static function lookupIFSC($ifsc_code)
    {
        $result = json_decode(self::api(
            null,
            self::$URL . "/" . $ifsc_code,
            array()
        ));

        return $result;
    }

}