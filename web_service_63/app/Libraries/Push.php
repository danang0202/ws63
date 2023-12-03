<?php

namespace App\Libraries;

class Push
{
    function sentMessage($fields)
    {
        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic ODExZjE3NDMtOGIxNS00NDRkLWIyMDEtNzQ0OTA2ZDM5YTk0'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function prepareDummyMessage($nim)
    {

        $fields = array(
            'app_id' => "2e8c2954-1ba7-4f1c-821d-f6c8fec65445",
            'filters' => array(array("field" => "tag", "key" => "nim", "relation" => "=", "value" => "$nim")),
            "template_id" => "016668ab-7a5d-47f5-9b1f-6e4f23c3529d"
        );

        return $this->sentMessage($fields);
    }

    function prepareMessageToNim($nim, $title, $message, $data = null)
    {
        $content = array(
            "en" => "$message"
        );

        $heading = array(
            "en" => "$title"
        );

        $group_message = array(
            "en" => "$[notif_count] $title"
        );

        $fields = array(
            'app_id' => "2e8c2954-1ba7-4f1c-821d-f6c8fec65445",
            'filters' => array(array("field" => "tag", "key" => "nim", "relation" => "=", "value" => "$nim")),
            'contents' => $content,
            'headings' => $heading,
            'small_icon' => 'capifix',
            'large_icon' => 'capifix',
            'android_sound' => 'capinurul',
            'android_group' => $title,
            'android_group_message' => $group_message,
            'data' => $data
        );

        if ($title = "Location Tracking Request") {
            $fields['ttl'] = 15;
        }

        return $this->sentMessage($fields);
    }

    function prepareMessageToSegment($segment, $title, $message, $data = null)
    {
        $content = array(
            "en" => "$message"
        );

        $heading = array(
            "en" => "$title"
        );

        $group_message = array(
            "en" => "$[notif_count] $title"
        );

        $fields = array(
            'app_id' => "2e8c2954-1ba7-4f1c-821d-f6c8fec65445",
            'included_segments' => array("$segment"),
            'excluded_segments' => array("AVOID"),
            'contents' => $content,
            'headings' => $heading,
            'small_icon' => 'capifix',
            'large_icon' => 'capifix',
            'android_sound' => 'capinurul',
            'android_group' => $title,
            'android_group_message' => $group_message,
            'data' => $data,
        );

        return $this->sentMessage($fields);
    }
}
