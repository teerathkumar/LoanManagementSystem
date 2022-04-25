<?php

class LMSPost {

    private $serverApiHosting = "http://localhost/SimaProjects/asaangharfinance_api/public/api";

    public function __construct($data) {
        echo "LMS Post";

        $token = $this->getToken("user@user.com", "password123");
//        print_r($token);
        if ($token) {
            extract($data);
            $headers = array(
                "Content-Type: application/json; charset=utf-8",
                "Authorization: Bearer " . $token
            );

//$fname
//$mname
//$lname
//$gender
//$dob
//$caste
//$cnic
//$mobile
//$address
//$amount
//$loan_tenure
//$markup_rate
//$loan_frequency
//$disb_date
//$rep_start_date
//$disb_date
//$rep_start_date

            $fields = array(
                "fname" => $fname,
                "lname" => $lname,
                "dob" => $dob,
                "gender" => $gender,
                "cnic" => $cnic,
                "mobile" => $mobile,
                "caste" => $caste,
                "address" => $address,
                "amount" => $amount,
                "loan_tenure" => $loan_tenure,
                "loan_frequency" => $loan_frequency,
                "markup_rate" => $markup_rate,
                "disb_date" => $disb_date,
                "rep_start_date" => $rep_start_date
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->serverApiHosting . '/borrower');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            curl_close($ch);
            $resp_array = json_decode($result);
            print_r($resp_array);
//            if ($resp_array) {
//                return $resp_array->data->token;
//            } else {
//                return 0;
//            }
        } else {
            echo "Issue in Token";
        }
    }

    public function getToken($username, $password) {

        $fields = array("email" => $username, "password" => $password);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->serverApiHosting . '/login');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        $resp_array = json_decode($result);
        if ($resp_array) {
            return $resp_array->data->token;
        } else {
            return 0;
        }
        //print_r($resp_array);
    }

}

$obj = new LMSPost($_REQUEST);
//print_r($_REQUEST);

