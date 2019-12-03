<?php
/*
 * Rest Class
 */

namespace alagaccia\mailchimp;

trait Rest
{
    protected $apikey;
    protected $baseurl;
    protected $list;

    public function __construct()
    {
        $this->baseurl = env('MAILCHIMP_BASEURL');
        $this->apikey = env('MAILCHIMP_APIKEY');
        $this->list = env('MAILCHIMP_LIST');
    }

    public function get($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, "user:{$this->apikey}");
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
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, "user:{$this->apikey}");
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
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, "user:{$this->apikey}");
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
}
