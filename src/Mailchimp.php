<?php
/*
 * Mailchimp Class
 */

namespace alagaccia\mailchimp;

use alagaccia\mailchimp\Rest;

class Mailchimp
{
    use Rest;


    public function listInfo()
    {
        $this->GET_LIST_INFO = "lists/{$this->LIST_ID}";

        return $this->get($this->GET_LIST_INFO);
    }

    public function member_count()
    {
        if ( $list = $this->listInfo() ) {
            return $list->stats->member_count;
        }

        return null;
    }

    public function getMember($email)
    {
        $this->GET_MEMBER = "lists/{$this->LIST_ID}/members/";

        return $this->GET($this->GET_MEMBER . md5(strtolower($email)));
    }

    public function updateMember($originalEmail, $data)
    {
        $this->GET_MEMBER = "lists/{$this->LIST_ID}/members/";
        $member = $this->GET($this->GET_MEMBER . md5(strtolower($originalEmail)));

        if ( isset($member) ) {
            $this->UPDATE_MEMBER = "/lists/{$this->LIST_ID}/members/";
            return $this->patch($this->UPDATE_MEMBER . md5(strtolower($originalEmail)), $data);
        }
        else {
            $this->UPDATE_MEMBER = "/lists/{$this->LIST_ID}/members/";
            return $this->put($this->UPDATE_MEMBER . md5(strtolower($originalEmail)), $data);
        }
    }

    public function storeMember($email, $data)
    {
        if ( ! $this->getMember($email) ) {
            $this->STORE_MEMBER =  "/lists/{$this->LIST_ID}/members/";

            return $this->post($this->STORE_MEMBER, $data);
        }

        return response()->json([
            'errors'=>'Cliente già esistente'
        ], 422);
    }
}
