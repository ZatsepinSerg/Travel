<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 30.01.2019
 * Time: 22:35
 */
namespace App\Models;

class Curl
{

    /**
     * @param string $data
     * @param string $url
     * @param string $type
     * @return mixed
     */
    public static function connect( string $url,string $data = "", string $type = "GET")
    {
        if (!$curl = curl_init()) {
            echo "error cUrl connect";
        }

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

            $response = curl_exec($curl);

            curl_close($curl);

            return $response;

    }


}