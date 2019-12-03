<?php
/*
 * Rest trait
 */

namespace alagaccia\mailchimp;

use alagaccia\mailchimp\Route;

trait Rest
{

    use Route;

    protected $API_KEY;
    protected $BASE_URL;
    protected $LIST_ID;

    public function __construct()
    {
        $this->BASE_URL = env('MAILCHIMP_BASEURL');
        $this->API_KEY = env('MAILCHIMP_APIKEY');
        $this->LIST_ID = env('MAILCHIMP_LIST');
    }

    public function get($url)
    {
        $url = $this->BASE_URL . $url;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, "user:{$this->API_KEY}");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($info["http_code"] == 200) {
            return json_decode($result);
        }

        return null;
    }

    public function patch($url, $data)
    {
        $url = $this->BASE_URL . $url;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, "user:{$this->API_KEY}");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($info["http_code"] == 200) {
            return json_decode($result);
        }

        return null;
    }

    public function put($url, $data)
    {
        $url = $this->BASE_URL . $url;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, "user:{$this->API_KEY}");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($info["http_code"] == 200) {
            return json_decode($result);
        }

        return null;
    }

    public function post($url, $data)
    {
        $url = $this->BASE_URL . $url;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, "user:{$this->API_KEY}");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($info["http_code"] == 200) {
            return json_decode($result);
        }

        return null;
    }
}
