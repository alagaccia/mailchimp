<?php
/*
 * Skebby Class
 */

namespace alagaccia\mailchimp;

class Mailchimp
{
    protected $apikey;
    protected $baseurl;
    protected $list;

    protected $GET_LIST_INFO;
    protected $GET_MEMBER;

    protected $UPDATE_MEMBER;


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

        // dd($data);
        // dd($result);

        if ($info["http_code"] == 200) {
            return json_decode($result);
        }

        return null;
    }
    /**
    * List information
    */
    public function listInfo()
    {
        $this->GET_LIST_INFO = "lists/{$this->list}";

        return $this->get($this->baseurl . $this->GET_LIST_INFO);
    }

    public function member_count()
    {
        if ( $list = $this->listInfo() ) {
            return $list->stats->member_count;
        }

        return null;
    }

    public function getMember($member)
    {
        $this->GET_MEMBER = "lists/{$this->list}/members/";

        return $this->GET($this->baseurl . $this->GET_MEMBER . md5(strtolower($member->email)));
    }
    public function updateMember($originalEmail, $data)
    {
        $this->GET_MEMBER = "lists/{$this->list}/members/";
        $member = $this->GET($this->baseurl . $this->GET_MEMBER . md5(strtolower($member->email)));

        if ( isset($member) ) {
            $this->UPDATE_MEMBER = "/lists/{$this->list}/members/";
            return $this->patch($this->baseurl . $this->UPDATE_MEMBER . md5(strtolower($originalEmail)), $data);
        }
    }
}
