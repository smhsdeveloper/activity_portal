<?php

function sendsms($APItype, $xmltype, $strmobileno, $dbname) {
    $username = '105029ApUh59QlBGt56c1793c';
    $sendername = "INVTCH";
    $xml_data = "";
    $mons = "";
    switch ($APItype) {
        case "GLOBEL":
            switch ($xmltype) {
                case "MmsgMno":
                    $count = 1;
                    $mobilenoarr = explode("`", $strmobileno);
                    $xml_data .= '<MESSAGE>';
                    $xml_data .= '<AUTHKEY>' . $username . '</AUTHKEY>';
                    $xml_data .= '<SENDER>' . $sendername . '</SENDER>';
                    $xml_data .= '<ROUTE>Template</ROUTE>';
                    $xml_data .= '<CAMPAIGN>Default</CAMPAIGN>';
                    $xml_data .= '<COUNTRY>91</COUNTRY>';
                    for ($i = 0; isset($mobilenoarr[$i]); $i = $i + 2) {
                        $msg = $mobilenoarr[$i];
                        $num = $mobilenoarr[$i + 1];
                        $code_random = $count;
                        $xml_data .= '<SMS TEXT="' . $msg . ' ">';
                        $xml_data .= '<ADDRESS TO="' . $num . '"></ADDRESS>';
                        $xml_data .= '</SMS>';
                        $count++;
                    }
                    $xml_data .= '</MESSAGE>';
                    break;
            }

            $datatopost = array("data" => $xml_data, "action" => "send",);
            $URL = "http://admin.bulksmslogin.com/api/postsms.php";
            $ch = curl_init($URL);
            curl_setopt($ch, CURLOPT_POST, 2);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datatopost);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output1 = curl_exec($ch);
            curl_close($ch);
            $XML = XMLtoArray($output1);
            if ($output1 <> "") {
                return "TRUE";
            } else {
                return "FALSE";
            }
            break;
        case "ZNI":
            switch ($xmltype) {
                case "OmsgMno":
                    $msg = $msgstr;
                    $mobilenoarr = explode("`", $strmobileno);
                    $xml_data = $xml_data . '<?xml version = "1.0" encoding = "ISO-8859-1"
                ?> <push> <authentication> <userid>cybuzzmittal</userid><apikey>331a25555a3d0bdb3a666869e9216423</apikey></authentication>';
                    $xml_data = $xml_data . '<senderid><gsm>MTCRML</gsm><cdma>9910373926</cdma></senderid>';
                    $xml_data = $xml_data . '<config><multisubmit>True</multisubmit></config>';
                    $xml_data = $xml_data . '<pushpacket>';
                    $xml_data = $xml_data . ' <packet>';
                    $xml_data = $xml_data . '<message><![CDATA[' . $msg . ']]></message>';
                    $xml_data = $xml_data . ' </packet>';
                    for ($i = 0; isset($mobilenoarr[$i]); $i++) {
                        $num = $mobilenoarr[$i];
                        $xml_data = $xml_data . '<packet>';
                        $xml_data = $xml_data . '<mobileno>' . $num . '</mobileno>';
                        $xml_data = $xml_data . '</packet>';
                    }
                    $xml_data = $xml_data . '</pushpacket>';
                    $xml_data = $xml_data . '</push>';
                    break;
                case "MmsgMno":
                    $msg = $msgstr;
                    $mobilenoarr = explode("`", $strmobileno);
                    $xml_data = $xml_data . '<?xml version="1.0" encoding="ISO-8859-1"?> <push> <authentication> <userid>cybuzzmittal</userid><apikey>331a25555a3d0bdb3a666869e9216423</apikey></authentication>';
                    $xml_data = $xml_data . '<senderid><gsm>MTCRML</gsm><cdma>9910373926</cdma></senderid>';
                    $xml_data = $xml_data . '<config><multisubmit>False</multisubmit></config>';
                    $xml_data = $xml_data . '<pushpacket>';
                    $msgarr = explode("`", $msgstr);
                    for ($i = 0; isset($mobilenoarr[$i]); $i++) {
                        $num = $mobilenoarr[$i];
                        $msg = $msgarr[$i];
                        $xml_data = $xml_data . '<packet>';
                        $xml_data = $xml_data . '<message><![CDATA[' . $msg . ']]></message>';
                        $xml_data = $xml_data . '<mobileno>' . $num . '</mobileno>';
                        $xml_data = $xml_data . '</packet>';
                    }
                    $xml_data = $xml_data . '</pushpacket>';
                    $xml_data = $xml_data . '</push>';
                    break;
            }
            $URL = "http://api.znisms.com/post/xmlmultismsv3.asp";
            $ch = curl_init($URL);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
            break;
    }
}

function XMLtoArray($XML) {
    $xml_parser = xml_parser_create();
    xml_parse_into_struct($xml_parser, $XML, $vals);
    xml_parser_free($xml_parser);
// wyznaczamy tablice z powtarzajacymi sie tagami na tym samym poziomie
    $_tmp = '';
    foreach ($vals as $xml_elem) {
        $x_tag = $xml_elem['tag'];
        $x_level = $xml_elem['level'];
        $x_type = $xml_elem['type'];
        if ($x_level != 1 && $x_type == 'close') {
            if (isset($multi_key[$x_tag][$x_level]))
                $multi_key[$x_tag][$x_level] = 1;
            else
                $multi_key[$x_tag][$x_level] = 0;
        }
        if ($x_level != 1 && $x_type == 'complete') {
            if ($_tmp == $x_tag)
                $multi_key[$x_tag][$x_level] = 1;
            $_tmp = $x_tag;
        }
    }
// jedziemy po tablicy
    foreach ($vals as $xml_elem) {
        $x_tag = $xml_elem['tag'];
        $x_level = $xml_elem['level'];
        $x_type = $xml_elem['type'];
        if ($x_type == 'open')
            $level[$x_level] = $x_tag;
        $start_level = 1;
        $php_stmt = '$xml_array';
        if ($x_type == 'close' && $x_level != 1)
            $multi_key[$x_tag][$x_level] ++;
        while ($start_level < $x_level) {
            $php_stmt .= '[$level[' . $start_level . ']]';
            if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level])
                $php_stmt .= '[' . ($multi_key[$level[$start_level]][$start_level] - 1) . ']';
            $start_level++;
        }
        $add = '';
        if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ($x_type == 'open' || $x_type == 'complete')) {
            if (!isset($multi_key2[$x_tag][$x_level]))
                $multi_key2[$x_tag][$x_level] = 0;
            else
                $multi_key2[$x_tag][$x_level] ++;
            $add = '[' . $multi_key2[$x_tag][$x_level] . ']';
        }
        if (isset($xml_elem['value']) && trim($xml_elem['value']) != '' && !array_key_exists('attributes', $xml_elem)) {
            if ($x_type == 'open')
                $php_stmt_main = $php_stmt . '[$x_type]' . $add . '[\'content\'] = $xml_elem[\'value\'];';
            else
                $php_stmt_main = $php_stmt . '[$x_tag]' . $add . ' = $xml_elem[\'value\'];';
            eval($php_stmt_main);
        }
        if (array_key_exists('attributes', $xml_elem)) {
            if (isset($xml_elem['value'])) {
                $php_stmt_main = $php_stmt . '[$x_tag]' . $add . '[\'content\'] = $xml_elem[\'value\'];';
                eval($php_stmt_main);
            }
            foreach ($xml_elem['attributes'] as $key => $value) {
                $php_stmt_att = $php_stmt . '[$x_tag]' . $add . '[$key] = $value;';
                eval($php_stmt_att);
            }
        }
    }
    return $xml_array;
}
