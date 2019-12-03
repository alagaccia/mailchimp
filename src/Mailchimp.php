<?php
/*
 * Mailchimp Class
 */

namespace alagaccia\mailchimp;
use Rest;

class Mailchimp
{
    use Rest;

    protected $GET_LIST_INFO;
    protected $GET_MEMBER;

    protected $UPDATE_MEMBER;


    public function __construct()
    {
        //
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

    public function getMember($originalEmail)
    {
        $this->GET_MEMBER = "lists/{$this->list}/members/";

        return $this->GET($this->baseurl . $this->GET_MEMBER . md5(strtolower($originalEmail)));
    }
    public function updateMember($originalEmail, $data)
    {
        $this->GET_MEMBER = "lists/{$this->list}/members/";
        $member = $this->GET($this->baseurl . $this->GET_MEMBER . md5(strtolower($originalEmail)));

        if ( isset($member) ) {
            $this->UPDATE_MEMBER = "/lists/{$this->list}/members/";
            return $this->patch($this->baseurl . $this->UPDATE_MEMBER . md5(strtolower($originalEmail)), $data);
        }
        else {
            $this->UPDATE_MEMBER = "/lists/{$this->list}/members/";
            return $this->put($this->baseurl . $this->UPDATE_MEMBER . md5(strtolower($originalEmail)), $data);
        }
    }
}
