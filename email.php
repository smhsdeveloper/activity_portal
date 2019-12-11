<?php

$to = 'adarsh.labh@invetechsolutions.com';
$subject = "OTP FOR 12-Jul-2016";
$txt = '<html>
                    <body>
                    <h2>OTP FOR 12-Jul-2016</h2>
                    <p>Dear Adarsh,</p>
                    <br/>
                    <p>Your OTP is ' . $genrateotp . ' ,Please validate your OTP </p>
                    <p>Kindly Visit the following URL </p>
                    <p>url :http://activity.smartechenergy.in/ </p>
                    <br/>
                    <p>Thanks & Regards,</p>
                    <h3>Adarsh Kumar</h3>
                    <p>Software Developer</p>
                    <p>INVETECH SOLUTIONS LLP</p>
                    <p>https://www.invetechsolutions.com</p>
                    <p>D/F +91-11-66666986 | M +91-9654664388</p>
                    <p>2F-CS, 53 Ansal Plaza,</p>
                    <p>Sector-1 Vaishali, Ghaziabad, Uttar Pradesh 201010</p>
                    </body>
                    </html>';

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: adarsh.labh@invetechsolutions.com' . "\r\n";
if (mail($to, $subject, $txt, $headers)) {
    echo 'Success';
} else {
    echo 'Err';
}
