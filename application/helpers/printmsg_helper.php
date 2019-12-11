<?php

/*
  function array_column($records, $key) {
  $myTempArr = array();
  foreach ($records as $value) {
  $myTempArr[] = $value[$key];
  }
  return $myTempArr;
  }
 */

function printCustomMsg($type, $msg = null, $value = -1) {
    $array = array();
    if ($msg == null) {
        switch ($type) {
            case "TRUE":
                $array['message'] = "Data Load Successfully";
                $array['result'] = "TRUE";
                break;
            case "TRUESAVE":
                $array['message'] = "Data Save Successfully";
                $array['result'] = "TRUE";
                break;
            case "TRUEUPDATE":
                $array['message'] = "Data Updated Successfully";
                $array['result'] = "TRUE";
                break;
            case "ERRLOAD":
                $array['message'] = "Data Load Successfully";
                $array['result'] = "ERR";
                break;
            case "ERRINPUT":
                $array['message'] = "Problem in Input please contact to admin";
                $array['result'] = "ERR";
                break;
            case "TRUESAVEERR":
                $array['message'] = "Data Not Save Successfully";
                $array['result'] = "ERR";
                break;

            default:
                break;
        }
    } else {
        $array['type'] = $type;
        $array['message'] = $msg;
        $array['result'] = $type;
    }
    $array['value'] = $value;
    return json_encode($array);
}

function changedateformate($date) {
    if ($date == "" || $date == "0000-00-00") {
        return $date;
    } else {
        $date_arr = explode("-", $date);
        $date_time = $date_arr[2] . "-" . $date_arr[1] . "-" . $date_arr[0];
        // $date_time = date("Y-m-d", mktime(0, 0, 0, $date_arr[1], $date_arr[0], $date_arr[2]));
        //$date_time=mktime(0, 0, 0, $date_arr[0], $date_arr[1], $date_arr[2]);
        return $date_time;
    }
}

function getMonthNames($monthNo = -1) {
    $monthNamewithNumber = array(
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    );
    if ($monthNo > 0) {
        return $monthNamewithNumber[$monthNo];
    } else {
        return $monthNamewithNumber;
    }
}

function getMonthNameUsingNumber($monhtNumber) {
    $dateObj = DateTime::createFromFormat('!m', $monhtNumber);
    $monthName = $dateObj->format('F'); // March
    return $monthName;
}

function BlockReviewAdmin() {
    return array(6, 58, 16, 72);
}

function GetMenuList() {
    $ci = & get_instance();
    $ci->load->model('login/login_model', "loginModel");
    return $ci->loginModel->getcurrentmenulist();
}

function getFinancialYearList() {
    $current_year = date('Y');
    $max_year = $current_year + 5;
    $year_array = array();
    for ($i = $current_year; $i < $max_year; $i++) {
        $year_array[$i] = $i . '-' . ($i + 1);
    }
    return $year_array;
}

function sendMyMail($mail, $emailArr, $ccArr, $subject, $msgContent) {
    $mail->IsSMTP();
    $mail->Host = 'smtp.sparkpostmail.com';
    $mail->Port = trim(587);
    $mail->SMTPAuth = true;
    $mail->Username = 'SMTP_Injection';
    $mail->Password = '40d2abab75db34ab59e7669c0541c1888469f1a0';
    $mail->Subject = $subject;
    $mail->MsgHTML($msgContent);
    $mail->SetFrom('no-reply@invetech.in', 'Activity');
    $mail->ClearAddresses();
    $mail->ClearAllRecipients();
    foreach ($ccArr as $value) {
        $mail->AddCC(trim($value));
    }
    foreach ($emailArr as $value) {
        $mail->AddAddress(trim($value));
    }
    $mail->AltBody = 'This is a plain-text message body';
    if (!$mail->Send()) {
        return "false" . $mail->ErrorInfo;
    } else {
        return "true";
    }
}

function VerifyDomain($domain) {
    $domainArr = array('kreatetechnologies.com');
    if (in_array($domain, $domainArr)) {
        return true;
    } else {
        return false;
    }
}

