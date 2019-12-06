<?php
/*
 * Mailchimp Class
 */

namespace alagaccia\mailchimp;

use alagaccia\mailchimp\Rest;

class Mailchimp
{
    use Rest;


    public function getListInfo()
    {
        $this->GET_LIST_INFO = "lists/{$this->LIST_ID}";

        return $this->get($this->GET_LIST_INFO);
    }

    public function getMembers($query = null)
    {
        $this->GET_MEMBERS = "lists/{$this->LIST_ID}/members{$query}";

        return $this->get($this->GET_MEMBERS);
    }

    public function total_members()
    {
        $total = 0;

        if ( $list = $this->getListInfo() ) {
            $total += $list->stats->member_count;
            $total += $list->stats->unsubscribe_count;
            $total += $list->stats->cleaned_count;
        }

        return $total;
    }

    public function total_subscribers()
    {
        if ( $list = $this->getlistInfo() ) {
            return $list->stats->member_count;
        }

        return null;
    }

    public function getMember($email)
    {
        $this->GET_MEMBER = "lists/{$this->LIST_ID}/members/";

        $res = $this->get($this->GET_MEMBER . md5(strtolower($email)));

        return $res;
    }

    public function updateMember($originalEmail, $data)
    {
        $this->GET_MEMBER = "lists/{$this->LIST_ID}/members/";
        $member = $this->get($this->GET_MEMBER . md5(strtolower($originalEmail)));

        if ( isset($member) ) {
            $this->UPDATE_MEMBER = "lists/{$this->LIST_ID}/members/";

            $res = $this->patch($this->UPDATE_MEMBER . md5(strtolower($originalEmail)), $data);

            return $res;
        }
        else {
            $data["email_address"] = $data["merge_fields"]["EMAIL"];
            $data["status"] = "subscribed";
            $res = $this->storeMember($originalEmail, $data);

            return $res;
        }
    }

    public function storeMember($client, $data)
    {
        if ( ! $this->getMember($client->email) ) {
            $this->STORE_MEMBER =  "lists/{$this->LIST_ID}/members/";

            $res = $this->post($this->STORE_MEMBER, $data);

            return $res;
        }

        return response()->json([
            'errors'=>'Cliente già esistente'
        ], 422);
    }
}
